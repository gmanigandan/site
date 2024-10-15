<?php
use App\Models\Backend\Settings;
use CommerceGuys\Addressing\Country\CountryRepository;
use CommerceGuys\Addressing\Subdivision\SubdivisionRepository;

if (!function_exists("website_setting")) {
    function website_setting($key, $default = null)
    {

        $cacheKey = 'website_setting_' . $key;

        // Attempt to retrieve the setting from the cache
        $setting = cache($cacheKey);

        // If not found in the cache, query the database and store in the cache
        if ($setting === null) {
            $setting = Settings::where('name', $key)->value('value');
            cache([$cacheKey => $setting], now()->addMinutes(60 * 24)); // Cache for 60 minutes
        }

        return $setting !== null ? $setting : $default;

    }
}

// Function to clear the cache for a specific setting
if (!function_exists('clear_website_setting_cache')) {
    function clear_website_setting_cache($key)
    {
        $cacheKey = 'website_setting_' . $key;
        cache()->forget($cacheKey);
    }
}
if (!function_exists('show_logo')) {
    function show_logo()
    {
        if (File::exists('storage/uploads/images/' . website_setting('site_logo'))) {
            return asset('storage/uploads/images/' . website_setting('site_logo'));
        } else {
            return asset('backend/assets/img/logo/logo.png');
        }


    }
}

if (!function_exists('join_path')) {
    function join_path($paths = [])
    {
        $pathname = DIRECTORY_SEPARATOR;
        if (!empty($paths)) {
            $pathname = DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $paths);
        }
        return $pathname;
    }
}
if (!function_exists('convertFromUSD')) {
    function convertFromUSD($amountUSD, $currency = 'INR')
    {
        // Check if cached exchange rates are available
        $cachedRates = Cache::get('exchange_rates');

        if (!$cachedRates) {
            // Fetch exchange rates from API if not cached
            $url = "https://open.er-api.com/v6/latest/USD";
            try {
                $response = json_decode(file_get_contents($url), true);
                Cache::put('exchange_rates', $response, now()->addDay());
                $cachedRates = $response;
            } catch (\Throwable $th) {
                //throw $th;
            }


            // Cache exchange rates for 24 hours



        }

        // Check if API request was successful and rates are available
        if ($cachedRates && isset($cachedRates['rates'][$currency])) {
            // Retrieve exchange rate for INR
            $exchangeRate = $cachedRates['rates'][$currency];

            // Convert amount from USD to INR
            $amountINR = $amountUSD * $exchangeRate;

            // Format the amount to have two decimal places
            $formattedAmountINR = number_format($amountINR, 2);

            return filter_var($formattedAmountINR, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        } else {
            // Handle error or fallback to default behavior
            return null;
        }
    }
}
if (!function_exists('getCountries')) {
    function getCountries($countryCode = null)
    {
        $countryRepository = new CountryRepository();
        if ($countryCode) {
            $countryRow = $countryRepository->get($countryCode);
            return $countryRow->getName();
        } else {
            return $countryRepository->getList();
        }
    }
}
if (!function_exists('getStates')) {
    function getStates($countryCode, $statesCode = null)
    {
        $subdivisionRepository = new SubdivisionRepository();
        $states = $subdivisionRepository->getAll([$countryCode]);
        $statesArray = [];
        foreach ($states as $state) {
            $statesArray[$state->getId()] = $state->getName();
        }

        if ($statesCode) {
            return (isset($statesArray[$statesCode]) && !empty($statesArray[$statesCode])) ? $statesArray[$statesCode] : $statesCode;
        } else {

            return $statesArray;
        }
    }
}
if (!function_exists('absolute_asset')) {
    function absolute_asset($path)
    {
        $baseUrl = config('app.url');
        return $baseUrl ? rtrim($baseUrl, '/') . '/' . ltrim($path, '/') : asset($path);
    }
}

if (!function_exists('industryCategories')) {
    function industryCategories()
    {

        return [
            'Agriculture' => 'Agriculture',
            'Automotive' => 'Automotive',
            'Construction' => 'Construction',
            'Education' => 'Education',
            'Energy' => 'Energy',
            'Finance' => 'Finance',
            'Healthcare' => 'Healthcare',
            'Hospitality' => 'Hospitality',
            'IT' => 'IT',
            'Manufacturing' => 'Manufacturing',
            'Real Estate' => 'Real Estate',
            'Retail' => 'Retail',
            'Telecommunications' => 'Telecommunications',
            'Transportation' => 'Transportation',
        ];
    }
}

if (!function_exists('jobTitles')) {
    function jobTitles()
    {

        return [
            'CEO' => 'CEO',
            'CTO' => 'CTO',
            'CFO' => 'CFO',
            'COO' => 'COO',
            'CMO' => 'CMO',
            'Manager' => 'Manager',
            'Supervisor' => 'Supervisor',
            'Engineer' => 'Engineer',
            'Technician' => 'Technician',
            'Consultant' => 'Consultant',
            'Analyst' => 'Analyst',
            'Director' => 'Director',
            'President' => 'President',
            'Vice President' => 'Vice President',
            'Administrator' => 'Administrator',
            'Specialist' => 'Specialist',
            'Coordinator' => 'Coordinator',
            'Assistant' => 'Assistant',
            'Executive' => 'Executive',
            'Officer' => 'Officer',
        ];
    }
}

if (!function_exists('showAddress')) {
    function showAddress($obj)
    {
        $addr = [];
        $stateName = $obj->state;
        if(!empty($obj->country) && !empty($obj->state))$stateName = getStates($obj->country,$obj->state);

        if(isset($obj->address) && !empty($obj->address)) $addr[] = $obj->address;
        if(isset($obj->area) && !empty($obj->area)) $addr[] = $obj->area;
        if(isset($obj->city) && !empty($obj->city)) $addr[] = $obj->city;
        if(isset($obj->state) && !empty($obj->state)) $addr[] = $stateName;
        if(isset($obj->country) && !empty($obj->country)) $addr[] = getCountries($obj->country);
        if(isset($obj->zipcode) && !empty($obj->zipcode)) $addr[] = $obj->zipcode;
        if(isset($obj->postcode) && !empty($obj->postcode)) $addr[] = $obj->postcode;

        return implode(', ', $addr);
    }
}
