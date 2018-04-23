# BankID Laravel

BankID implementation php and laravel. 

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

What things you need to install the software and how to install them

```
1. PHP >= 5.6
2. Soap Extention
```

### Installing

A step by step series of examples that tell you have to get a development env running

Say what the step will be
#### Laravel with composer
```
composer require anwar/bankid
```

For laravel <=  5.4 
Edit config/App.php 
Add below line on provider

```
		Anwar\Bankid\BankidServiceProvider::class,
```

And if you want to use Facade
```
		"BankID":Anwar\Bankid\BankidFacad::class,
```

### Implementation
``` PHP
<?php

namespace App\Http\Controllers;

use BankID;
use Illuminate\Http\Request;

class GuzzleTest extends Controller {

	public function __construct() {
		$this->middleware('web');
	}

	public function bankid(Request $httpsrequestdata) {
		/**
		 * Initial BankID Service With wsdl url and
		 * Certificate
		 *
		 *
		 */
		//$cer = "E:\\xamp\htdocs\Demo\public\ssl/file.pem";
		$cer = "E:\\xamp\htdocs\Demo\public\ssl/FP.pem";

		//$httpsrequestdata = new Request();

		$initial = BankID::start('https://appapi2.test.bankid.com/rp/v4?wsdl',
			['local_cert' => $cer],
			false);

		if (session()->has("orderRef")) {
			//return session()->get("orderRef");
			//session()->forget("orderRef");
			$response = BankID::collectResponse(session()->get("orderRef"));
			if ($response->progressStatus == "COMPLETE") {
				session()->forget("orderRef");
				session()->put('compl', 'true');
				return json_encode($response->userInfo);
				//return "complete";
			} else {
				session()->forget("orderRef");
				return $response->progressStatus;
			}
		} else {
			//if (property_exists('Request', 'personalnumber')) {
			$personalnum = $httpsrequestdata->personalnumber;
			//return session()->get("orderRef");
			$response1 = BankID::getAuthResponse($personalnum, "192.168.20.231", '123456');

			if (is_object($response1) && $response1->orderRef != "") {
				$response = BankID::collectResponse($response1->orderRef);
				//session(['orderRef' => $response->orderRef]);
				Session()->put('orderRef', $response1->orderRef);
				session('orderRef', $response1->orderRef);
				return json_encode(session()->get("orderRef"));
				return session()->get("orderRef");
			} else {
				return "no num";
				return $response->progressStatus;
			}

		}
		//}

	}
}

```

And create a view like

``` PHP
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="m-b-md">
                    <form method="post">

                        <div class="form-gorup">
                            <label for="personalnumber">Personal Number</label>
                            <input type="number" id="personalnumber" name="personalnumber" class="form-control" value="199012247590">

                            <input type="submit" class="btn btn-success" name="psubmit" id="psubmit" value="Submit">
                        </div>

                    </form>
                </div>

                <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

                <script>
                    $(document).ready(function() {

                        $(document).on('click', "#psubmit", function(event) {
                            event.preventDefault();
                            /* Act on the event */
                            personalnumber = $("#personalnumber").val();

                            if (personalnumber != "") {
                                //alert(personalnumber);
                                $.ajax({
                                    url: "{{ route('bankid') }}",
                                    type: 'GET',
                                    data: {personalnumber: personalnumber},
                                })
                                .done(function(data,xhs) {
                                    console.log(data);
                                })
                                .fail(function(data) {
                                    console.log("error");
                                })


                            }
                        });
                    });
                </script>
            </div>
        </div>
    </body>
</html>


```

## Original Package

* [dimafe6/bank-id](https://github.com/dimafe6/bank-id/) - This buit in raw php.


## Converting Lravel Package
* [Anwar Jahid](https://anwarjahid.com/) - Anwar Jahid

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* For Further Assistant Feel Free to Contact `` ajr.jahid@gmail.com ``
