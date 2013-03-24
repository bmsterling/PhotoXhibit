<?php

class PXGallery {
    var $base;
    var $path;
    
    function __construct ($base) {
        $this->base = $base;
        $this->path = plugin_dir_path($base);
    }
    
    public function index () {
        
        wp_enqueue_script( 'px-settings-admin-script', plugins_url( 'photoxhibit/assets/js/gallery.js' ), array('jquery','backbone','underscore') );
        
        
        // $gallery = array();

        $data = array(
            "options" => get_option('photoxhibit'),
            "gallery" => array()
        );
        
        $v = new PXView( $this->path . '/assets/views/gallery/select-service.php');
        $selectservice = $v->fetch( $data );
        
        $v = new PXView( $this->path . '/assets/views/gallery/smugmug-initial.php');
        $smugmuginitial = $v->fetch( $data );
        
        $v = new PXView( $this->path . '/assets/views/gallery/smugmug-sizes.php');
        $smugmugsizes = $v->fetch( $data );
        
        $v = new PXView( $this->path . '/assets/views/gallery/flickr-initial.php');
        $flickrinitial = $v->fetch( $data );
        
        $v = new PXView( $this->path . '/assets/views/gallery/flickr-basic.php');
        $flickrbasic = $v->fetch( $data );
        
        $v = new PXView( $this->path . '/assets/views/gallery/flickr-photoset.php');
        $flickrphotoset = $v->fetch( $data );
        
        $v = new PXView( $this->path . '/assets/views/gallery/flickr-search.php');
        $flickrsearch = $v->fetch( $data );
        
        $v = new PXView( $this->path . '/assets/views/gallery/flickr-sizes.php');
        $flickrsizes = $v->fetch( $data );
        
        $v = new PXView( $this->path . '/assets/views/gallery/selections.php');
        $selections = $v->fetch( $data );
        
        $v = new PXView( $this->path . '/assets/views/gallery/selectables.php');
        $selectables = $v->fetch( $data );
        
        $v = new PXView( $this->path . '/assets/views/gallery/photo-view-template.php');
        $photoviewtemplate = $v->fetch( $data );
        
        $this->data = array(
            'select-service'      => $selectservice,
            'smugmug-initial'     => $smugmuginitial,
            'smugmug-sizes'       => $smugmugsizes,
            'flickr-basic'        => $flickrbasic,
            'flickr-initial'      => $flickrinitial,
            'flickr-photoset'     => $flickrphotoset,
            'flickr-search'       => $flickrsearch,
            'flickr-sizes'        => $flickrsizes,
            'selectables'         => $selectables,
            'selections'          => $selections,
            'photo-view-template' => $photoviewtemplate
        );
        
        // $pxmodel = new PXModel();
    
        // $this->data = $pxmodel->get_galleries();
        
        $v = new PXView( $this->path . '/assets/views/gallery/base.php');
        $fetch = $v->fetch($this->data);
        
        print($fetch);
    }
    
    public function routeAjax () {
        extract($_GET);
        
        switch ($hopper) {
            case 'getPhotos' :
                switch ($service) {
                    case 'picasa':
                    case 'flickr':
                    case 'smugmugA':
                        echo $this->get_album_json($url, $small, $large);
                        break;
                }
            break;
        }
        
        die();
    }

    private function check_set_allow_url_fopen($do = NULL){
        $allow_fopen = (ini_get('allow_url_fopen') == '1');
        
        switch($do){
            case 'open':
                if (!$allow_fopen) {
                    ini_set('allow_url_fopen', 'On');
                    if(ini_get('allow_url_fopen') != 'On'){
                        die("{'result':'error','errorType':'no_fopen'}");
                    }
                }
                break;
            case 'close':
                if (!$allow_fopen) {
                    ini_set('allow_url_fopen', '0');
                }
                break;
        }
    }

    /**
     *	Get Album JSON
     */
    public function get_album_json($url = NULL, $small, $large){
        header('Content-type: application/json');
        
        $this->check_set_allow_url_fopen('open');
        $url = str_replace(array('rss_200','rss'),'json',$url);
        $service = '';
        
        if(strpos($url, 'flickr') === false){}
        else{
            $url .= '&nojsoncallback=1&format=json';
            $service = 'flickr';
        }
        
        if(preg_match("/smugmug/", $url)){
            preg_match('/APIKey=(.*)&method/ise', $url, $matches);
            $info = file_get_contents("http://api.smugmug.com/hack/json/1.2.0/?APIKey=".$matches[1]."&method=smugmug.login.anonymously");

            $return = json_decode($info);
            
            $url .= "&SessionID=".$return->Login->Session->id;
            $service = 'smugmug';
        }
        $return = @file_get_contents($url);
        $this->check_set_allow_url_fopen('close');
        
        
        $this->standardize(&$return,$service, $small, $large);
        
        return  ($return) ? '{"result":true,"records" : ' . $return . '}' : '{"result":"error","errorType":"fileGetContent"}';
    }
    
    private function standardize ($data,$service, $small, $large) {
        $records = array();
        
        $data = explode("\n", $data);
        
        $data =  str_replace('\"', '"', $data);
        $data = str_replace('\"', '"', $data);
        $data = str_replace('\{', '{', $data);
        $data =  str_replace('\}', '}', $data);
        $data =  str_replace('""', '"\"', $data);
        $data =  str_replace('\\\'', '\'', $data);
        
        function clean(&$value) { 
            $value = eregi_replace('"description"[ :]+[.]*"(.*)[",$]', '', $value); 
            $value = ltrim ($value);
            $value = rtrim ($value);
        }
        array_walk($data, 'clean');
        
        $data = join('',$data);
        $dataJSON = json_decode($data);
        
        // if ($service == 'flickr') {
            // $dataJSON = ereg_replace('"description": "(.)+"', '', $data);
        // }
        // else{
            // $dataJSON = $data;
        // }
        // var_dump($dataJSON);
        // $dataJSON = json_decode($dataJSON);

// Define the errors.
// $constants = get_defined_constants(true);
// $json_errors = array();
// foreach ($constants["json"] as $name => $value) {
    // if (!strncmp($name, "JSON_ERROR_", 11)) {
        // $json_errors[$value] = $name;
    // }
// }

// Show the errors for different depths.
// foreach (range(10, 3, -1) as $depth) {
    // var_dump(json_decode($data, true, $depth));
    // echo 'Last error: ', $json_errors[json_last_error()], PHP_EOL, PHP_EOL;
// }
        
        
        // echo($data);
        // var_dump($dataJSON);
        
        if ($service == 'flickr') {
            
            foreach ($dataJSON->items as $item) {
                // var_dump($item);
                $record = array(
                    "square"    => ereg_replace('_m\\.','_q.', $item->media->m),
                    "small"     => ereg_replace('_m\\.', $small.'.', $item->media->m),
                    "full"      => ereg_replace('_m\\.', $large.'.', $item->media->m),
                    "original"  => ereg_replace('_m\\.', '_b.', $item->media->m),
                    "title"     => $item->title,
                    "index"     => 0
                );
                
                array_push( $records, $record);
            }
        }
        else if ($service == 'smugmug') {
        
        }
        
        // var_dump($records);
        // var_dump($dataJSON);
        
        $data = json_encode($records);
    }
}