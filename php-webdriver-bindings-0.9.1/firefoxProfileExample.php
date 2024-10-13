<?php
/*
Copyright 2011 3e software house & interactive agency

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

     http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/


require_once "phpwebdriver/WebDriver.php";

$webdriver = new WebDriver("localhost", 4444);
$ffprofile = $webdriver->prepareBrowserProfile("pathToYourFFProfileDirectory");
$webdriver->connect("firefox","15",array('firefox_profile' => $ffprofile));                            
$webdriver->get("http://google.com");
$element = $webdriver->findElementBy(LocatorStrategy::name, "q");
if ($element) {
    $element->sendKeys(array("php webdriver" ) );
    $element->submit();
}
$webdriver->close();
?>