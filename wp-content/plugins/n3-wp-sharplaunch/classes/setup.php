<?php 
if (!class_exists('GPC_Core_SHARPLAUNCH')) {
    class GPC_Core_SHARPLAUNCH {
        function __construct()  {

            // Add settings link to Plugin page
            add_action('admin_menu' , array( $this, '___addMenu' ) );
            add_action('admin_bar_menu', array( $this, '___addToAdminBar' ), 100 );

        }

        public function SL_Authentication() {
            $url = 'https://app.sharplaunch.com/apiv2';
            $response = $this->call_api($url);
            return $response;
        }

        public function SL_DownloadImage($id) {
            $url = 'https://admin.sharplaunch.com/v2/image/' . $id . '/2500w';
            $api_key = get_option('nguyen_api');
            $args = array(
                'headers' => array(
                    'X-APIKEY' => $api_key,
                    'Content-Type' => 'application/json'
                )
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_HEADER, false);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.1 Safari/537.11');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-APIKEY: ' . $api_key,
                'Content-Type: application/json'
            ));
            $res = curl_exec($ch);  
            $rescode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
            curl_close($ch) ;
            return $res;
        }

        public function SL_GetProperties() {
            $url = 'https://app.sharplaunch.com/apiv2/websites';
            $response = $this->call_api($url);
            return $response;
        }

        // get Properties by ID 
        public function SL_GetPropertiesByID($id) {
            $url = 'https://app.sharplaunch.com/apiv2/website/' . $id;
            $response = $this->call_api($url);
            return $response;
        }

        // get Members
        public function SL_GetMembers() {
            $url = 'https://app.sharplaunch.com/apiv2/members';
            $response = $this->call_api($url);
            return $response;
        }
        // get Leads
        public function SL_GetLeads() {
            $url = 'https://app.sharplaunch.com/apiv2/leads';
            $response = $this->call_api($url);
            return $response;
        }   

        public function call_api($url) {
            $api_key = get_option('nguyen_api');
            $args = array(
                'headers' => array(
                    'X-APIKEY' => $api_key,
                    'Content-Type' => 'application/json'
                )
            );
            $response = wp_remote_get( $url, $args );
            if ( is_wp_error( $response ) ) {
                $error_message = $response->get_error_message();
                return "Something went wrong: $error_message";
            } else {
                return json_decode($response['body']) ?? [];
            }
        }

        public function ___addMenu( ) {
            add_menu_page(
                'N3 Sharplaunchs',
                'N3 Sharplaunchs',
                'manage_options',
                'n3_sharplaunchs',
                array( $this, '___settingsPage' ),
                'dashicons-admin-generic',
                39
            );
            add_submenu_page(
                'n3_sharplaunchs',
                'Members',
                'Members',
                'manage_options',
                'n3_sharplaunchs_member',
                array($this, '___memberPage')
            );
            add_submenu_page(
                'n3_sharplaunchs',
                'Properties',
                'Properties',
                'manage_options',
                'n3_sharplaunchs_properties',
                array($this, '___propertiesPage')
            );
            add_submenu_page(
                'n3_sharplaunchs',
                'Leads',
                'Leads',
                'manage_options',
                'n3_sharplaunchs_leads',
                array($this, '___leadsPage')
            );
            // ADD HIDEN PAGE `n3_sharplaunchs_properties_view`
            add_submenu_page(
                null,
                'Properties View',
                'Properties View',
                'manage_options',
                'n3_sharplaunchs_properties_view',
                array($this, '___propertiesViewPage')
            );
        }

        public function ___memberPage() {
            require_once( plugin_dir_path( __FILE__ ) . 'member.php' );
        }

        public function ___propertiesPage() {
            require_once( plugin_dir_path( __FILE__ ) . 'properties.php' );
        }

        public function ___propertiesViewPage() {
            require_once( plugin_dir_path( __FILE__ ) . 'properties_view.php' );
        }

        public function ___leadsPage() {
            require_once( plugin_dir_path( __FILE__ ) . 'leads.php' );
        }

        public function ___settingsPage() {
            require_once( plugin_dir_path( __FILE__ ) . 'setting_global.php' );
        }

        public function ___addToAdminBar() {
            global $wp_admin_bar;
            $wp_admin_bar->add_menu( array(
                'id'    => 'gp-sharplaunchs',
                'title' => esc_html__( 'N3 Sharplaunchs', 'gp-theme' ),
                'parent' => 'made_theme_options',
                'href'  => admin_url( 'admin.php?page=n3_sharplaunchs' ),
            ));
        }

        public function get_lat_long($address){
            $key = get_option('nguyenmapapikey') ? get_option('nguyenmapapikey') : Redux::get_option('made_theme', 'google-map-api-key');
            $region = "USA";
            $address = str_replace(" ", "+", $address);
            $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=$region&key=$key");
            $json = json_decode($json);
            if ($json->error_message) {
                return '3454353,7897897';
            }
            $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
            $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
            return $lat.','.$long ?? '';
        }

        public function getStateNameByCode($code) {
            $states = array(
                'AL' => 'Alabama',
                'AK' => 'Alaska',
                'AZ' => 'Arizona',
                'AR' => 'Arkansas',
                'CA' => 'California',
                'CO' => 'Colorado',
                'CT' => 'Connecticut',
                'DE' => 'Delaware',
                'DC' => 'District Of Columbia',
                'FL' => 'Florida',
                'GA' => 'Georgia',
                'HI' => 'Hawaii',
                'ID' => 'Idaho',
                'IL' => 'Illinois',
                'IN' => 'Indiana',
                'IA' => 'Iowa',
                'KS' => 'Kansas',
                'KY' => 'Kentucky',
                'LA' => 'Louisiana',
                'ME' => 'Maine',
                'MD' => 'Maryland',
                'MA' => 'Massachusetts',
                'MI' => 'Michigan',
                'MN' => 'Minnesota',
                'MS' => 'Mississippi',
                'MO' => 'Missouri',
                'MT' => 'Montana',
                'NE' => 'Nebraska',
                'NV' => 'Nevada',
                'NH' => 'New Hampshire',
                'NJ' => 'New Jersey',
                'NM' => 'New Mexico',
                'NY' => 'New York',
                'NC' => 'North Carolina',
                'ND' => 'North Dakota',
                'OH' => 'Ohio',
                'OK' => 'Oklahoma',
                'OR' => 'Oregon',
                'PA' => 'Pennsylvania',
                'RI' => 'Rhode Island',
                'SC' => 'South Carolina',
                'SD' => 'South Dakota',
                'TN' => 'Tennessee',
                'TX' => 'Texas',
                'UT' => 'Utah',
                'VT' => 'Vermont',
                'VA' => 'Virginia',
                'WA' => 'Washington',
                'WV' => 'West Virginia',
                'WI' => 'Wisconsin',
                'WY' => 'Wyoming',
            );
            return $states[$code];
        }

        
    }
}

new GPC_Core_SHARPLAUNCH();
