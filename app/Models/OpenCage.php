<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Exception;
use stdClass;

class OpenCage extends Model
{
    use HasFactory;

    public string $status_code;
    public string $ISO_3166_alpha_2;
    public string $ISO_3166_alpha_3;
    public string $CountryCode;
    public string $Continent;
    public string $PostalCode;
    public string $StateCode;
    public string $State;
    public string $City;
    public string $CurrencyISOCod;
    public string $timezoneOffsetString;
    public string $timezoneDST;
    public string $timezoneShortNameString;
    public string $latitude;
    public string $longitude;
    public string $openStreetMapsURL;

    public $command;
    public $url;
    public $JSON;

    private $key;
    private $geocodeURL;
    private $reverseGeocodeURL;

    public function __construct(array $attributes = []){
        parent::__construct($attributes);
        $this->key = "8210b4b052b243119e3a841adf1aab3e";
        $this->geocodeURL = 'https://api.opencagedata.com/geocode/v1/json';
        $this->reverseGeocodeURL = 'https://api.opencagedata.com/geocode/v1/json';
    }


    /**
     * Forward GeoCode
     *
     * @param string $street1
     * @param string $city
     * @param string $state_province
     * @param string $postal_code
     * @param string $countryCode
     * @param string $continent
     * @return bool
     */
    public function forwardGeoCodeAddressSearch( string $street1 = "",
                                                 string $city = "",
                                                 string $state_province = "",
                                                 string $postal_code = "",
                                                 string $countryCode = "us",
                                                 string $continent = "North America" ){

        // ignore street 2 and street 3, can lead to inaccuracies
        $q = $this->formGeoCodeSearchString(
            $continent,
            $postal_code,
            $state_province,
            $city,
            $street1,
            "",
            "");

        // form the query command
        $this->command           = ['q'      =>  $q];
        $this->command           += ['countrycode' => $countryCode];
        $this->command           += ['key' => $this->key];
        $this->command           += ['language' => 'en'];
        $this->command           += ['limit'  =>  1];     // only return the first result

        // perform the cURL query then decode the response
        try {
            $this->JSON = json_decode($this->CallAPI('GET', $this->geocodeURL, $this->command));

            if ($this->validResponse($this->JSON)) {
                $this->parseOpenCageJson($this->JSON);
                return true;
            }
        } catch (Exception $e){
            debugbar()->error($e);
        }

        return false;
    }

    /**
     * Is the OpenCage cURL return valid
     * @param $JSON  stdClass opencagedata JSON
     * @return bool valid JSON return
     */
    public function validResponse($JSON){
        $this->location_status_code = $JSON->status->code;
        if ($this->location_status_code == "200") return true;
        return false;
    }


    /**
     * Form the OpenCage Forward GeoCode Search String
     * @param string $continent
     * @param string $country
     * @param string $postal_code
     * @param string $state_province
     * @param string $city
     * @param string $street1
     * @param string $street2
     * @param string $street3
     * @return string
     */
    function formGeoCodeSearchString(string $continent, string $postal_code, string $state_province, string $city, string $street1, string $street2, string $street3){
        $search = "";
        $addPlus = false;


        if (strlen($street1) > 0) {
            if ($addPlus) {
                $search .= ',';
            }
            $search .= $street1;
            $addPlus = true;
        }
        if (strlen($street2) > 0) {
            if ($addPlus) {
                $search .= ',';
            }
            $search .= $street2;
            $addPlus = true;
        }
        if (strlen($street3) > 0) {
            if ($addPlus) {
                $search .= ',';
            }
            $search .= $street3;
            $addPlus = true;
        }
        if (strlen($city) > 0) {
            if ($addPlus) {
                $search .= ',';
            }
            $search .= $city;
            $addPlus = true;
        }
        if (strlen($state_province) > 0) {
            if ($addPlus) {
                $search .= ',';
            }
            $search .= $state_province;
            $addPlus = true;
        }
        if (strlen($postal_code) > 0) {
            if ($addPlus) {
                $search .= ',';
            }
            $search .= $this->removeSpaces($postal_code);   // remove or put %20??
            $addPlus = true;
        }
//        if (strlen($continent) > 0) {
//            $search .= $continent;
//            $addPlus = true;
//
//        }

        return $search;     // test: do not http encode the stirng yet, we do that last.
//        return $this->webSpaces($search);        // properly formatted search
    }


    /**
     *
     * cURL API Core
     * @param $method string POST, PUT, GET
     * @param $url string
     * @param $data array|null ("parameter" => "value) : url?param=value
     * @return bool|string
     */
    public function CallAPI(string $method, string $url, $data = null)
    {
        $curl = curl_init();

        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            case "GET":
            default:
                if ($data)
                    $this->url = sprintf("%s?%s", $url, http_build_query($data,"", "&", PHP_QUERY_RFC3986));
        }

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }

    /**
     * Exchange Spaces for  %20 and return
     * @param $string
     * @return string
     */
    public function webSpaces($string){
        return str_replace(" ", "%20", $string);
    }

    /**
     * Remove Spaces and return
     * @param $string
     * @return string
     */
    public function removeSpaces($string){
        return str_replace(" ", "", $string);
    }


    /**
     * Parse the Open Cage JSON Data
     * @param $JSON
     * @return void
     */
    private function parseOpenCageJson($JSON){
        if (isset($JSON->total_results) && $JSON->total_results > 0) {
            try {
                $this->ISO_3166_alpha_2 = $JSON->results[0]->components->{'ISO_3166-1_alpha-2'};
                $this->ISO_3166_alpha_3 = $JSON->results[0]->components->{'ISO_3166-1_alpha-3'};
                $this->Continent = $JSON->results[0]->components->continent;
                $this->CountryCode = $JSON->results[0]->components->country_code;
                if (isset($JSON->results[0]->components->postcode)) $this->PostalCode = $JSON->results[0]->components->postcode;
                if (isset($JSON->results[0]->components->state_code)) $this->StateCode = $JSON->results[0]->components->state_code;
                if (isset($JSON->results[0]->components->state)) $this->State = $JSON->results[0]->components->state;
                $this->CurrencyISOCode = $JSON->results[0]->annotations->currency->iso_code;
                $this->timezoneOffsetString = $JSON->results[0]->annotations->timezone->offset_string;
                $this->timezoneDST = $JSON->results[0]->annotations->timezone->now_in_dst;
                $this->timezoneShortNameString = $JSON->results[0]->annotations->timezone->short_name;
                $this->latitude = $JSON->results[0]->geometry->lat;
                $this->longitude = $JSON->results[0]->geometry->lng;
                if (isset($JSON->results[0]->components->city)) $this->City = $JSON->results[0]->components->city;

                $this->openStreetMapsURL = $JSON->results[0]->annotations->OSM->url;

            } catch (\Exception $e) {
                debugbar()->error($e->getMessage());
            }
        }
    }

}
