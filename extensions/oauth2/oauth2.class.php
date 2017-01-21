<?php

class OAuth2 {
	
	public $accessToken;
	public $requestResponse;
	public $curlData;
	private $settings;
	
	function __construct($settings = null) {
		if (! is_null ( $settings ) && $this->checkSettings ( $settings )) {
			$this->settings = $settings;
			$this->router ();
		} else {
			return "Please provide the appropriate settings";
		}
	}
	
	private function checkSettings($settings) {
		$count = 0;
		foreach ( $settings as $key => $val ) {
			switch ($key) {
				case 'endpoint' :
				case 'token_endpoint' :
				case 'client_id' :
				case 'client_secret' :
				case 'redirect_uri' :
				case 'scope' :
				case 'grant_type' :
				case 'access_type' :
				case 'approval_prompt' :
				case 'response_type' :
					{
						if (! $val == "") {
							$count ++;
						}
					}
					break;
			}
		}
		if ($count == 10) {
			return true;
		} else {
			return false;
		}
	}
	
	private function router() {
		if (isset ( $_REQUEST ['error'] )) {
			$this->errorHandler ();
		} else if (isset ( $_REQUEST ['code'] )) {
			$this->settings ['code'] = $_REQUEST ['code'];
			$this->authResponseHandler ();
		} else {
			$this->createRequest ();
		}
	}
	
	private function createRequest() {
		$url = $this->settings ['endpoint'] . "?scope=" . urlencode ( $this->settings ['scope'] ) . "&redirect_uri=" . urlencode ( $this->settings ['redirect_uri'] ) . "&response_type=" . urlencode ( $this->settings ['response_type'] ) . "&client_id=" . urlencode ( $this->settings ['client_id'] ) . "&access_type=" . $this->settings ['access_type'];
		$this->requestResponse = $url;
	}
	
	private function authResponseHandler() {
		$postFields = "code=" . $this->settings ['code'] . "&client_id=" . $this->settings ['client_id'] . "&client_secret=" . $this->settings ['client_secret'] . "&redirect_uri=" . $this->settings ['redirect_uri'] . "&grant_type=" . $this->settings ['grant_type'];
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $this->settings ['token_endpoint'] );
		curl_setopt ( $ch, CURLOPT_POST, true );
		curl_setopt ( $ch, CURLINFO_HEADER_OUT, true );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $postFields );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		$result = curl_exec ( $ch );
		$this->accessToken = $result;
	}
}