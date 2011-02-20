<?php

/*
 * Nathan Le Ray (oyokoon@syrinxoon.net) http://syrinxoon.net
 *
 * The first PHP Library to support (mt) Media Temple's API.
 */

/**
 * (mt) API class
 */
class MtAPI {
	
  /* Contains the last HTTP status code returned. */
  public $http_code;
  /* Contains the last HTTP headers returned. */
  public $http_info;
  /* Contains the last API call. */
  public $url;
  /* Set up the API root URL. */
  public $host = 'https://api.mediatemple.net/api/v1/';
  /* Respons format. */
  public $format = 'json';
  /* Decode returned json data. */
  public $decode_json = TRUE;
  /* Set wrapRoot default */
  public $wrap_root = FALSE;
  /* Set prettyPrint default */
  public $pretty_print = FALSE;
  /* Set timeout default. */
  public $timeout = 30;
  /* Set connect timeout. */
  public $connecttimeout = 30; 
  /* Verify SSL Cert. */
  public $ssl_verifypeer = FALSE;
  /* Set the useragent. */
  public $useragent = 'PHP MtAPI v1.0-beta1';
	/* Contains the API key */
	private $api_key;
	/* Contains the service ID */
	private $service_id;


  /**
   * Set API URLS
   */
  function servicesAPI() { return $this->host . 'services'; }
  function statsAPI() { return $this->host . 'stats'; }

  /**
   * Debug helpers
   */
  function lastStatusCode() { return $this->http_status; }
  function lastAPICall() { return $this->last_api_call; }

  /**
   * Construct (mt) API object
   */
  function __construct($api_key, $service_id = NULL) {
  	
  	if ($api_key == '' || strlen($api_key) != 65) { die('Invalid API Key'); }
  	if (!is_int($service_id) && $service_id != NULL) { die('Invalid Service ID'); }
  	
  	$this->api_key = $api_key;
  	$this->service_id = $service_id;
  	
  }
 
  /**
   * Set service ID 
   */
  function set_service_id($service_id) { if (is_int($service_id)) { $this->service_id = $service_id; } }
  
  
  /** SERVICES METHODS **/
  
  
  /**
   * Add a service
   */
	function add_service($service_type, $primary_domain = '', $os = 16) {
		
		if (!is_int($service_type)) { die('Invalid service type.'); }
		if (!is_int($service_type)) { die('Invalid operating system. '); }
		
		if ($service_type >= 725) {
			
			if ($primary_domain == '') { die('You must provide a primary domain'); }
			
			$json = array('serviceType' => $service_type, 'primaryDomain' => $primary_domain);
			$post_data = json_encode($json);
			
		}
		else {
			
			$json = array('serviceType' => $service_type, 'operatingSystem' => $operating_system);
			$post_data = json_encode($json);
			
		}		
		
		$url = $this->servicesAPI();
		$results = $this->api_call($url, 'POST', array(), $post_data);
		return $this->decode_results($results);
		
	}
	
  /**
   * Get operating systems list
	 */
	function get_os_list() {
		
		$url = $this->servicesAPI() . '/types/os';
		$results = $this->api_call($url, 'GET');
		return $this->decode_results($results);
		
	}
	
	/**
   * Get available_services
	 */
	function get_available_services() {
		
		$url = $this->servicesAPI() . '/types';
		$results = $this->api_call($url, 'GET');
		return $this->decode_results($results);
		
	}
	
  /**
   * Get services list
	 */
	function get_services_list() {
		
		$url = $this->servicesAPI();
		$results = $this->api_call($url, 'GET');
		return $this->decode_results($results);
		
	}
	
	/**
   * Get services ids
	 */
	function get_services_ids() {
		
		$url = $this->servicesAPI() . '/ids';
		$results = $this->api_call($url, 'GET');
		return $this->decode_results($results);
		
	}
	
	/**
	 * Get service details
	 */
	function get_service_details() {
		
		$this->check_service_id();
		
		$url = $this->servicesAPI() . '/' . $this->service_id;
		$results = $this->api_call($url, 'GET');
		return $this->decode_results($results);
		
	}
	
	/**
	 * Reboot a service
	 */
	function reboot_service() {
		
		$this->check_service_id();
		
		$url = $this->servicesAPI() . '/' . $this->service_id . '/reboot';
		$results = $this->api_call($url, 'POST');
		return $this->decode_results($results);
		
	}
	
	/**
	 * Set Plesk password
	 */
	function set_plesk_password($password) {
		
		$this->check_service_id();
		
		$url = $this->servicesAPI() . '/' . $this->service_id . '/pleskPassword';
		$results = $this->api_call($url, 'PUT', '{"password": "' . $password . '"}');
		return $this->decode_results($results);
		
	}
	
	/**
	 * Set root password
	 */
	function set_root_password($password) {
		
		$this->check_service_id();
		
		$url = $this->servicesAPI() . '/' . $this->service_id . '/rootPassword';
		$results = $this->api_call($url, 'PUT', '{"password": "' . $password . '"}');
		return $this->decode_results($results);
		
	}
	
	/**
	 * Add temporary disk space
	 */
	function add_temp_disk() {
		
		$this->check_service_id();
		
		$url = $this->servicesAPI() . '/' . $this->service_id . '/disk/temp';
		$results = $this->api_call($url, 'POST');
		return $this->decode_results($results);
		
	}
	
	/**
	 * Flush firewall rules
	 */
	function flush_firewall() {
		
		$this->check_service_id();
		
		$url = $this->servicesAPI() . '/' . $this->service_id . '/firewall/flush';
		$results = $this->api_call($url, 'POST');
		return $this->decode_results($results);
		
	}
	
	
	/** STATS METHODS **/
	
	
	/*
	 * Get current stats
	 */
	function get_current_stats() {
		
		$this->check_service_id();
		
		$url = $this->statsAPI() . '/' . $this->service_id;
		$results = $this->api_call($url, 'GET');
		return $this->decode_results($results);
		
	}
	
	/*
	 * Get range stats
	 */
	function get_range_stats($start, $end, $resolution = 15, $precision = 2) {
		
		if (!is_int($start) || !is_int($end) || !is_int($resolution) || !is_int($precision)) { die('All params must be of type int.');	}
		
		$this->check_service_id();
		
		$get_data = array(
			'start'      => $start,
			'end'        => $end,
			'resolution' => $resolution,
			'precision'  => $precision
			);
		
		$url = $this->statsAPI() . '/' . $this->service_id;
		$results = $this->api_call($url, 'GET', array(), array(), $get_data);
		return $this->decode_results($results);
		
	}
	
	/*
	 * Get predefined range stats
	 */
	function get_predefined_range_stats($range) {
		
		$ranges = array('5min', '15min', '30min', '1hour', '1day', '1week', '1month', '3month', '1year');
		
		if (!in_array($range, $ranges)) { die('Invalid range.'); }
		
		$this->check_service_id();
		
		$url = $this->statsAPI() . '/' . $this->service_id . '/' . $range;
		$results = $this->api_call($url, 'GET');
		return $this->decode_results($results);
		
	}
	
	/*
	 * Get warnings
	 */
	function get_warnings() {
		
		$this->check_service_id();
		
		$url = $this->statsAPI() . '/warnings';
		$results = $this->api_call($url, 'GET');
		return $this->decode_results($results);
		
	}
	
	/*
	 * Get wrnings
	 */
	function get_warnings_thresholds() {
		
		$this->check_service_id();
		
		$url = $this->statsAPI() . '/warnings/thresholds';
		$results = $this->api_call($url, 'GET');
		return $this->decode_results($results);
		
	}
	
	
	/** UTILS **/
	
	
	/**
	 * Check if a service ID match the API Key
	 */
	function check_service_id() {
		
		if (!is_int($this->service_id)) die("You must set your service ID before using this function.");
		
		$config = array($this->format, $this->decode_json, $this->wrap_root);
		$this->format = 'json';
		$this->decode_json = TRUE;
		$this->wrap_root = FALSE;
		
		$services = $this->get_services_ids();
		$exists =  array_keys($services, $this->service_id);
		if (empty($exists)) die("The service ID $this->service_id doesn't match your API Key.");
		
		$this->format = $config[0];
		$this->decode_json = $config[1];
		$this->wrap_root = $config[2];
		
	}	
	
	/**
	 * Decode API results
	 *
	 * @return Decoded JSON string or plain text
	 */
	function decode_results($results) {
		
		if ($this->format === 'json' && $this->decode_json) { return json_decode($results);	}
		
		return $results;
		
	}
	
	/**
	 * Make an API call
	 *
	 * @return API results
	 */
	function api_call($url, $method = 'POST', $put_data = '', $post_data = array(), $get_data = array()) {
		
		$this->http_info = array();
    $ch = curl_init();
    
    $headers = array('Expect:');
    
    /* Curl settings */
    curl_setopt($ch, CURLOPT_USERAGENT, $this->useragent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connecttimeout);
    curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->ssl_verifypeer);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
		
    if ($method == 'POST') {
    	
    	$headers[] = "Authorization: MediaTemple $this->api_key";
    	$headers[] = "Accept: application/$this->format";
    	$headers[] = "Content-type: application/$this->format";
    	
    	curl_setopt($ch, CURLOPT_POST, TRUE);
    	
    	if (!empty($post_data)) {
      	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
      }
      
      if ($this->wrap_root == FALSE) $url .= '?wrapRoot=false';
      
    }
    elseif ($method == 'PUT') {
    	
    	$headers[] = "Authorization: MediaTemple $this->api_key";
    	$headers[] = "Accept: application/$this->format";
    	$headers[] = "Content-type: application/json";
    	
			if (!$put_file = tmpfile()) die('Can\'t create the temp file.');
			fwrite($put_file, $put_data);
			fseek($put_file, 0);
    	
    	curl_setopt($ch, CURLOPT_PUT, TRUE);
			curl_setopt($ch, CURLOPT_INFILE, $put_file);
			curl_setopt($ch, CURLOPT_INFILESIZE, strlen($put_data));
    	
    }
    elseif ($method == 'GET') {
    	
    	$url .= '.' . $this->format . '?apikey=' . $this->api_key;
    	if ($this->wrap_root == FALSE) $url .= '&wrapRoot=false';
    	
    	if (!empty($get_data)) {
    		
    		foreach ($get_data as $key => $value) {
    			
    			$url .= '&' . $key . '=' . $value;
    			
    		}
    		
    	}
    	
    }
    
    if ($this->pretty_print) $url .= '&prettyPrint=true';

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $url);
    
    $response = curl_exec($ch);
    
    $this->http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $this->http_info = array_merge($this->http_info, curl_getinfo($ch));
    $this->url = $url;
    $this->last_api_call = $url;
    
    curl_close ($ch);
    
    if ($method == 'PUT') fclose($put_file);
    
    return $response;
    
  }
  
}