<?php

/*
 * 
 * The MIT License (MIT)
 * Copyright (c) 2011 Mauro Gonzalez 
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy 
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell 
 * copies of the Software, and to permit persons to whom the Software is 
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in 
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE 
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER 
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, 
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN 
 * THE SOFTWARE.
 * 
 */

require_once realpath(dirname(__FILE__) . '/../../../../bootstrap.php');

define('NETWORK_NAME', "Facebook");
define('PROTECTED_RESOURCE_URL', "https://graph.facebook.com/me");
$EMPTY_TOKEN =  new Token('','');

$apiKey = "your app id";
$apiSecret = "your api secret";
$callbackUrl = "http://www.example.com/oauth_callback/";

$builder = new ServiceBuilder();
$service = $builder->provider(new FacebookApi())
  ->apiKey($apiKey)
  ->apiSecret($apiSecret)
  ->callback($callbackUrl)
  ->build();


print("=== ". NETWORK_NAME ."'s OAuth Workflow ===\n");
print("\n");

print("Go and authorize Scribe here: \n");
print($service->getAuthorizationUrl($EMPTY_TOKEN) . "\n");
fwrite(STDOUT, "And paste the verifier here: ");

$verifier = new Verifier(trim(fgets(STDIN)));
print("\n");

// Trade the Request Token and Verfier for the Access Token
print("Trading the Request Token for an Access Token...\n");
$accessToken = $service->getAccessToken($requestToken, $verifier);
print("Got the Access Token!\n");
print("(if your curious it looks like this: " . $accessToken . " )\n");
print("\n");

// Now let's go and ask for a protected resource!
print("Now we're going to access a protected resource...\n");


$request = new OAuthRequest(Verb::GET, PROTECTED_RESOURCE_URL);
$service->signRequest($accessToken, $request);
$response = $request->send();

print("Got it! Lets see what we found...\n");
print("\n");
print($response->getBody());

print("\n");
print("Thats it man! Go and build something awesome with Scribe! :)\n");
print("\n");
print("\n");
