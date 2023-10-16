<?php 

include  'PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
include 'PHPMailer-master/PHPMailer-master/src/Exception.php';
include "PHPMailer-master/PHPMailer-master/src/SMTP.php";

// Creates New Spreadsheet


if (isset($_POST['submit'])) {  
    $headers = array(
        'Full Name',
        'Phone Number',
        'Email',
        'Title',
        'Company Name',
        'Address',
        'City',
        'State',
        'Zip Code',
        'Property Value',
        'Value Established',
        'Liens on Property',
        'Owner Occupied',
      
        'Land Included',
        'Land Plot Size',
        'Mobile Home Titled',
        'Additional Details',
        'Date of Sale',
        'Sales Price',
        'Down Payment',
        'Used Attorney or Title Company',
        'Has Title Policy',
        'Original Note Amount',
        'Note Position',
        'Note Balance',
        'Interest Rate',
        'Payment Amount',
        'Date of First Payment',
        'Payment Frequency',
        'Original Length',
        'Payments Made',
        'Payments Remaining',
        'Next Due Date',
        'Title Policy',
        'Balloon Amount',
        'Borrower Type',
        'Borrower Name',
        'Credit Report',
        'Credit Rating',
        'Borrower Employment',
        'Additional Info',
        'Our Monthly Installments Calculations',
        'Our Loan Calculations'
    );
    // Retrieve form data
    $fullName = $_POST['First'] . ' ' . $_POST['Last'];
    $phoneNumber = $_POST['Phone_Number'];
    $email = $_POST['email'];
    $title = $_POST['your_title'];
    $companyName = $_POST['company_name'];
    $address = $_POST['property_address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipCode = $_POST['zip_code'];
    $propertyValue = $_POST['property_value'];
    $valueEstablished = $_POST['establishment'];
    $liensOnProperty = $_POST['liens'];
    $ownerOccupied = $_POST['property_owner'];
   
    $landIncluded = $_POST['land_inc'];
    $landPlotSize = $_POST['land_plot'];
    $mobileHomeTitled = $_POST['mobile_home_tka'];
    $additionalDetails = $_POST['additional_details'];
    $dateOfSale = $_POST['date_of_sale'];
    $salesPrice = $_POST['sales_price'];
    $downPayment = $_POST['down_payment'];
    $usedAttorneyOrTitleCompany = $_POST['attorney'];
    $hasTitlePolicy = $_POST["has_title_policy"];
    $originalNoteAmount = $_POST['note_amount'];
    $notePosition = $_POST['position_note'];
    $noteBalance = $_POST['note_balance'];
    $interestRate = $_POST["interest_rate"];
    $paymentAmount = $_POST["payment_amount"];
    $dateFirstPayment = $_POST["date_first"];
    $paymentFrequency = $_POST["payment_frequency"];
    $originalLength = $_POST["orginal_length"];
    $paymentsMade = $_POST["payment_made"];
    $paymentsRemaining = $_POST["payment_remaining"];
    $nextDueDate = $_POST["next_due_date"];
    $titlePolicy = $_POST["title_policy"];
    $balloonAmount = $_POST["balloon_amount"];
    $balloonDueDate = $_POST["ballon_date"];
    $borrowerType = $_POST["borrower_type"];
    $borrowerName = $_POST["borrower_name"];
    $creditReport = $_POST["credit_report"];
    $creditRating = $_POST["credit_range"];
    $borrowerEmployment = $_POST["borrower"];
    $additionalInfo = $_POST["additional_info"];

    // Prepare the data for CSV
    $data = array(
        $fullName,
        $phoneNumber,
        $email,
        $title,
        $companyName,
        $address,
        $city,
        $state,
        $zipCode,
        $propertyValue,
        $valueEstablished,
        $liensOnProperty,
        $ownerOccupied,
      
        $landIncluded,
        $landPlotSize,
        $mobileHomeTitled,
        $additionalDetails,
        $dateOfSale,
        $salesPrice,
        $downPayment,
        $usedAttorneyOrTitleCompany,
        $hasTitlePolicy,
        $originalNoteAmount,
        $notePosition,
        $noteBalance,
        $interestRate,
        $paymentAmount,
        $dateFirstPayment,
        $paymentFrequency,
        $originalLength,
        $paymentsMade,
        $paymentsRemaining,
        $nextDueDate,
        $titlePolicy,
        $balloonAmount,
        $borrowerType,
        $borrowerName,
        $creditReport,
        $creditRating,
        $borrowerEmployment,
        $additionalDetails,
      
    );

    // Open the file for writing
      // Check if the file exists
      if (!file_exists('data.csv')) {
        // Open the file in write mode
        $file = fopen('data.csv', 'w');

        // Write the headers to the file
        fputcsv($file, $headers);

        // Close the file
        fclose($file);
    }

    // Open the file in append mode
    $file = fopen('data.csv', 'a');

    // Write the data to the file
    fputcsv($file, $data);

    // Close the file
    fclose($file);
 
if($paymentFrequency==="Quaterly"){
    $originalLength=$originalLength*3;
}
if($paymentFrequency==="Semi-Annually"){
    $originalLength=$originalLength*6;
}
if($paymentFrequency==="Annually"){
    $originalLength=$originalLength*12;
}
    
$mail = new PHPMailer\PHPMailer\PHPMailer(true);
$additionalInfo = $_POST["additional_info"];

$C2 = $originalNoteAmount; // Property Value
$C3 = $interestRate; // Interest Rate
$C4 = $originalLength; // Original Length

// Calculate the monthly payment using the formula
$monthlyInterestRate = ($C3 / 100) / 12;
$monthlyPayment = round($C2 * ($monthlyInterestRate * pow((1 + $monthlyInterestRate), $C4)) / (pow((1 + $monthlyInterestRate), $C4) - 1));
$C6 = $monthlyPayment; // Desired monthly payment
$E4 = 12; // Annual interest rate
$C4 = $originalLength; // Loan term in months
$C5 = $paymentsMade; // Number of months already paid

// Calculate the monthly interest rate
$monthlyInterestRate = $E4 /12/100;

// Calculate the remaining loan term
$remainingLoanTerm = $C4 - $C5;

// Evaluate the formula to find the loan amount
$loanAmount = round($C6 * ((1 - pow(1 + ($monthlyInterestRate), -$remainingLoanTerm)) / ($monthlyInterestRate)));
$message="";
if($monthlyPayment==$paymentAmount){
// Email body text with HTML formatting
$message.="Name:$fullName\n";
$message.="Email:$email\n";
$message.="Property Address:$address\n";
$message = "Property Value: $propertyValue\n";
$message .= "Value Established: $valueEstablished\n";
$message .= "Liens on Property: $liensOnProperty\n";
$message .= "Owner Occupied: $ownerOccupied\n";
$message .= "Land Included: $landIncluded\n";
$message .= "Land Plot Size: $landPlotSize\n";
$message .= "Mobile Home Titled: $mobileHomeTitled\n";
$message .= "Additional Details: $additionalDetails\n";
$message .= "Date of Sale: $dateOfSale\n";
$message .= "Sales Price: $salesPrice\n";
$message .= "Down Payment: $downPayment\n";
$message .= "Used Attorney or Title Company: $usedAttorneyOrTitleCompany\n";
$message .= "Has Title Policy: $hasTitlePolicy\n";
$message .= "Original Note Amount: $originalNoteAmount\n";
$message .= "Note Position: $notePosition\n";
$message .= "Note Balance: $noteBalance\n";
$message .= "Interest Rate: $interestRate\n";
$message .= "Payment Amount: $paymentAmount\n";
$message .= "Date of First Payment: $dateFirstPayment\n";
$message .= "Payment Frequency: $paymentFrequency\n";
$message .= "Original Length: $originalLength\n";
$message .= "Payments Made: $paymentsMade\n";
$message .= "Payments Remaining: $paymentsRemaining\n";
$message .= "Next Due Date: $nextDueDate\n";
$message .= "Title Policy: $titlePolicy\n";
$message .= "Balloon Amount: $balloonAmount\n";
$message .= "Balloon Due Date: $balloonDueDate\n";
$message .= "Borrower Type: $borrowerType\n";
$message .= "Borrower Name: $borrowerName\n";
$message .= "Credit Report: $creditReport\n";
$message .= "Credit Rating: $creditRating\n";
$message .= "Borrower Employment: $borrowerEmployment\n";
$message .= "Additional Info: $additionalInfo\n";
$message .= "Monthly Payment: $monthlyPayment\n";
$message .= "These figures are contingent upon our due diligence $loanAmount \n";


}
else{
    $message="Your figures are not matching with our calculations. Please contact us ";
}

    try {
        // Configure the SMTP settings for Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'kakinvestments7@gmail.com';
        $mail->Password = 'tfulwejlluhvdozp';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
    
        // Set the sender and recipient email addresses
        $mail->setFrom('kakinvestments7@gmail.com', 'K A K Investments');
        $mail->addAddress($email, $fullName);
    
        // Set email subject and content
        $mail->Subject = 'Preliminary Note Quote';
        $mail->Body = $message;
              
    
        // Send the email
        if ($mail->send()) {
            $messag= 'Email sent successfully.';
        } else {
            echo 'Failed to send the email. Error: ' . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo 'An error occurred: ' . $e->getMessage();
    }
}




 


if (isset($_POST["submit"])) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Your response received successfully. We will send an email to you shortly. Please Contact us on any furthur details
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
}





?>











<!DOCTYPE html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<html data-scrapbook-create="20230417032443960" data-scrapbook-source="https://www.kakifg.com/mortgage-note-quote/" data-scrapbook-title="Mortgage Note Quote" lang="en-US">
<head><meta charset="utf-8"><script>if(navigator.userAgent.match(/MSIE|Internet Explorer/i)||navigator.userAgent.match(/Trident¥/7¥..*?rv:11/i)){var href=document.location.href;if(!href.match(/[?&]nonitro/)){if(href.indexOf("?")==-1){if(href.indexOf("#")==-1){document.location.href=href+"?nonitro=1"}else{document.location.href=href.replace("#","?nonitro=1#")}}else{if(href.indexOf("#")==-1){document.location.href=href+"&nonitro=1"}else{document.location.href=href.replace("#","&nonitro=1#")}}}}</script><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex, follow">
	<title>Selling a Mortgage Note for Residential Property?</title>
	<link rel="icon" type="image/ico" href="Gold-Luxury-Initial-Circle-Logo.ico">
	
	<link as="style" href="nitro-min-noimport-c7edace81c5ab0f7dec5b27034f1714e.main.min.css" rel="stylesheet" />
	<style onerror="NPRL.onErrorStyle(this)" onload="NPRL.onLoadStyle(this)" type="text/css">img.wp-smiley, img.emoji { display: inline !important; border: none !important; box-shadow: none !important; height: 1em !important; width: 1em !important; margin: 0px 0.07em !important; vertical-align: -0.1em !important; background: none !important; padding: 0px !important; }
	</style>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="nitro-min-noimport-4101156e54d759d797b61d170b1eb835.8121f7253270160f5170a4759fbe75db-stylesheet.css" onerror="NPRL.onErrorStyle(this)" onload="NPRL.onLoadStyle(this)" rel="stylesheet" />
	<style id="global-styles-inline-css" onerror="NPRL.onErrorStyle(this)" onload="NPRL.onLoadStyle(this)" type="text/css">body { --wp--preset--color--black:#000; --wp--preset--color--cyan-bluish-gray:#abb8c3; --wp--preset--color--white:#fff; --wp--preset--color--pale-pink:#f78da7; --wp--preset--color--vivid-red:#cf2e2e; --wp--preset--color--luminous-vivid-orange:#ff6900; --wp--preset--color--luminous-vivid-amber:#fcb900; --wp--preset--color--light-green-cyan:#7bdcb5; --wp--preset--color--vivid-green-cyan:#00d084; --wp--preset--color--pale-cyan-blue:#8ed1fc; --wp--preset--color--vivid-cyan-blue:#0693e3; --wp--preset--color--vivid-purple:#9b51e0; --wp--preset--gradient--vivid-cyan-blue-to-vivid-purple:linear-gradient(135deg,rgba(6,147,227,1) 0%,#9b51e0 100%); --wp--preset--gradient--light-green-cyan-to-vivid-green-cyan:linear-gradient(135deg,#7adcb4 0%,#00d082 100%); --wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange:linear-gradient(135deg,rgba(252,185,0,1) 0%,rgba(255,105,0,1) 100%); --wp--preset--gradient--luminous-vivid-orange-to-vivid-red:linear-gradient(135deg,rgba(255,105,0,1) 0%,#cf2e2e 100%); --wp--preset--gradient--very-light-gray-to-cyan-bluish-gray:linear-gradient(135deg,#eee 0%,#a9b8c3 100%); --wp--preset--gradient--cool-to-warm-spectrum:linear-gradient(135deg,#4aeadc 0%,#9778d1 20%,#cf2aba 40%,#ee2c82 60%,#fb6962 80%,#fef84c 100%); --wp--preset--gradient--blush-light-purple:linear-gradient(135deg,#ffceec 0%,#9896f0 100%); --wp--preset--gradient--blush-bordeaux:linear-gradient(135deg,#fecda5 0%,#fe2d2d 50%,#6b003e 100%); --wp--preset--gradient--luminous-dusk:linear-gradient(135deg,#ffcb70 0%,#c751c0 50%,#4158d0 100%); --wp--preset--gradient--pale-ocean:linear-gradient(135deg,#fff5cb 0%,#b6e3d4 50%,#33a7b5 100%); --wp--preset--gradient--electric-grass:linear-gradient(135deg,#caf880 0%,#71ce7e 100%); --wp--preset--gradient--midnight:linear-gradient(135deg,#020381 0%,#2874fc 100%); --wp--preset--duotone--dark-grayscale:url("#wp-duotone-dark-grayscale"); --wp--preset--duotone--grayscale:url("#wp-duotone-grayscale"); --wp--preset--duotone--purple-yellow:url("#wp-duotone-purple-yellow"); --wp--preset--duotone--blue-red:url("#wp-duotone-blue-red"); --wp--preset--duotone--midnight:url("#wp-duotone-midnight"); --wp--preset--duotone--magenta-yellow:url("#wp-duotone-magenta-yellow"); --wp--preset--duotone--purple-green:url("#wp-duotone-purple-green"); --wp--preset--duotone--blue-orange:url("#wp-duotone-blue-orange"); --wp--preset--font-size--small:13px; --wp--preset--font-size--medium:20px; --wp--preset--font-size--large:36px; --wp--preset--font-size--x-large:42px; --wp--preset--spacing--20:0.44rem; --wp--preset--spacing--30:0.67rem; --wp--preset--spacing--40:1rem; --wp--preset--spacing--50:1.5rem; --wp--preset--spacing--60:2.25rem; --wp--preset--spacing--70:3.38rem; --wp--preset--spacing--80:5.06rem; }


	</style>
    <style>
       .alert {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            width: 100%;
            padding: 15px;
            background-color: rgb(212, 237, 218); /* Green background color for success message */
            color: black; /* White text color for success message */
            font-size:12px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
</style>
	<template data-nitro-marker-id="92c1631b0b5bf66c5f934ae7bdd10cb0-1"></template>
	<link href="http://gmpg.org/xfn/11" rel="profile" /> <noscript><link rel="stylesheet" href="main.min.css"></noscript> <template data-nitro-marker-id="7c99f700325ec31bbc4b2bcfee6c6864-1"></template> <script type="application/ld+json" class="yoast-schema-graph">{"@context":"https://schema.org","@graph":[{"@type":"WebPage","@id":"https://www.kakifg.com/mortgage-note-quote/","url":"https://www.kakifg.com/mortgage-note-quote/","name":"Selling a Mortgage Note for Residential Property?","isPartOf":{"@id":"https://www.kakifg.com/#website"},"datePublished":"2014-03-22T12:56:37+00:00","dateModified":"2021-11-24T15:36:55+00:00","description":"Looking to sell residential notes? Fill out our simple quote form, and see how much you can earn selling a mortgage note for your residential property.","breadcrumb":{"@id":"https://www.kakifg.com/mortgage-note-quote/#breadcrumb"},"inLanguage":"en-US","potentialAction":[{"@type":"ReadAction","target":["https://www.kakifg.com/mortgage-note-quote/"]}]},{"@type":"BreadcrumbList","@id":"https://www.kakifg.com/mortgage-note-quote/#breadcrumb","itemListElement":[{"@type":"ListItem","position":1,"name":"Home","item":"https://www.kakifg.com/"},{"@type":"ListItem","position":2,"name":"Mortgage Note Quote"}]},{"@type":"WebSite","@id":"https://www.kakifg.com/#website","url":"https://www.kakifg.com/","name":"KAKIFG.","description":"","publisher":{"@id":"https://www.kakifg.com/#organization"},"potentialAction":[{"@type":"SearchAction","target":{"@type":"EntryPoint","urlTemplate":"https://www.kakifg.com/?s={search_term_string}"},"query-input":"required name=search_term_string"}],"inLanguage":"en-US"},{"@type":"Organization","@id":"https://www.kakifg.com/#organization","name":"KAKIFG.","url":"https://www.kakifg.com/","sameAs":["https://www.facebook.com/profile.php?id=100092027015982","https://twitter.com/kak_ifg"],"logo":{"@type":"ImageObject","inLanguage":"en-US","@id":"https://www.kakifg.com/#/schema/logo/image/","url":"https://www.kakifg.com/wp-content/uploads/2019/08/logo.jpg","contentUrl":"https://www.kakifg.com/wp-content/uploads/2019/08/logo.jpg","width":320,"height":58,"caption":"KAKIFG."},"image":{"@id":"https://www.kakifg.com/#/schema/logo/image/"}}]}</script>
	<link href="https://www.kakifg.com/mortgage-note-quote/feed/" rel="alternate" title="KAKIFG. ﾃつｻ Mortgage Note Quote Comments Feed" type="application/rss+xml" /> <template data-nitro-marker-id="df9834de29bed96b040b7a50058d6741-1"></template> <template data-nitro-marker-id="jquery-core-js"></template>
	<link href="https://www.kakifg.com/wp-json/" rel="https://api.w.org/" />
	<link href="https://www.kakifg.com/wp-json/wp/v2/pages/296" rel="alternate" type="application/json" />
	<link href="https://www.kakifg.com/xmlrpc.php?rsd" rel="EditURI" title="RSD" type="application/rsd+xml" />
	<link href="https://www.kakifg.com/wp-includes/wlwmanifest.xml" rel="wlwmanifest" type="application/wlwmanifest+xml" />
	<link href="https://www.kakifg.com/?p=296" rel="shortlink" />
	<link href="https://www.kakifg.com/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fwww.kakifg.com%2Fmortgage-note-quote%2F" rel="alternate" type="application/json+oembed" />
	<link href="https://www.kakifg.com/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fwww.kakifg.com%2Fmortgage-note-quote%2F&amp;format=xml" rel="alternate" type="text/xml+oembed" />
	<link href="" rel="icon" sizes="32x32" />
	<link href="../favicon/android-chrome-192x192.png" rel="icon" sizes="192x192" />
	<link href="../favicon/android-chrome-192x192.png" rel="apple-touch-icon" /><script nitro-exclude="">window.IS_NITROPACK=!0;window.NITROPACK_STATE='FRESH';</script><script>window.nitro_lazySizesConfig=window.nitro_lazySizesConfig||{};window.nitro_lazySizesConfig.lazyClass="nitro-lazy";nitro_lazySizesConfig.srcAttr="nitro-lazy-src";nitro_lazySizesConfig.srcsetAttr="nitro-lazy-srcset";nitro_lazySizesConfig.expand=10;nitro_lazySizesConfig.expFactor=1;nitro_lazySizesConfig.hFac=1;nitro_lazySizesConfig.loadMode=1;nitro_lazySizesConfig.ricTimeout=50;nitro_lazySizesConfig.loadHidden=true;(function(){var t=null;var e=false;var i=false;var r={childList:false,attributes:true,subtree:false,attributeFilter:["src"],attributeOldValue:true};var n=null;var a=[];function o(t){let e=a.indexOf(t);if(e>-1){a.splice(e,1);n.disconnect();c()}t.contentWindow.location.replace(t.getAttribute("nitro-og-src"))}function l(){if(!n){n=new MutationObserver(function(t,a){t.forEach(n=>{if(n.type=="attributes"&&n.attributeName=="src"){let e=n.target;let i=e.getAttribute("nitro-og-src");let r=e.src;if(r!=i){a.disconnect();let t=r.replace(n.oldValue,"");if(r.indexOf("data:")===0&&["?","&"].indexOf(t.substr(0,1))>-1){if(i.indexOf("?")>-1){e.setAttribute("nitro-og-src",i+"&"+t.substr(1))}else{e.setAttribute("nitro-og-src",i+"?"+t.substr(1))}}e.src=n.oldValue;c()}}})})}return n}function s(t){l().observe(t,r)}function c(){a.forEach(s)}function u(){window.removeEventListener("scroll",u);window.nitro_lazySizesConfig.expand=300}window.addEventListener("scroll",u,{passive:true});window.addEventListener("NitroStylesLoaded",function(){e=true});window.addEventListener("load",function(){i=true});window.addEventListener("message",function(t){if(t.data.action&&t.data.action==="playBtnClicked"){var e=document.getElementsByTagName("iframe");for(var i=0;i<e.length;i++){if(t.source===e[i].contentWindow){o(e[i])}}}});document.addEventListener("lazybeforeunveil",function(r){var n=false;var a=r.target.getAttribute("nitro-lazy-bg");if(a){let t=r.target.style.backgroundImage.replace("data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAAAICTAEAOw==",a.replace(/¥(/g,"%28").replace(/¥)/g,"%29"));if(t===r.target.style.backgroundImage){t="url("+a.replace(/¥(/g,"%28").replace(/¥)/g,"%29")+")"}let e=r.target.style.backgroundImage;let i=["initial","inherit"].indexOf(e.toLowerCase())===-1;if(e&&i){t=e+", "+t}r.target.style.backgroundImage=t;n=true}if(!n){var t=r.target.tagName.toLowerCase();if(t!=="img"&&t!=="iframe"){r.target.querySelectorAll("img[nitro-lazy-src],img[nitro-lazy-srcset]").forEach(function(t){t.classList.add("nitro-lazy")})}}});document.addEventListener("DOMContentLoaded",function(){document.querySelectorAll("iframe[nitro-og-src]").forEach(e=>{if(e.getAttribute("nitro-og-src").indexOf("vimeo")>-1){e.realGetAttribute=e.getAttribute;Object.defineProperty(e,"src",{value:e.getAttribute("nitro-og-src"),writable:false});Object.defineProperty(e,"getAttribute",{value:function(t){if(t=="src"){return e.realGetAttribute("nitro-og-src")}else{return e.realGetAttribute(t)}},writable:false})}a.push(e)});c()})})();</script><script id="nitro-lazyloader">/*! lazysizes - v5.1.2 */


</script>
</head>
<body class="page-template-default page page-id-296"><noscript><iframe src="index_1.html" height="0" width="0" style="display: none; visibility: hidden;"></iframe></noscript>
<div class="top-bar">
<div class="container">
<div class="row">
<div class="col-md-6"><span>1212 Byron Ave SW, | Decatur | Al 35601</span></div>

<div class="col-md-6 social-icons"><a href="https://www.facebook.com/KAKInvestmentFamilyGroup" target="_blank"><svg viewbox="0 0 320 512" xmlns="http://www.w3.org/2000/svg"><path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path></svg></a> <a href="https://twitter.com/kak_ifg" target="_blank"> <svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg></a> <a href="https://www.youtube.com/channel/UCV6s9G_yhmTquaTPdZ-EOww" target="_blank"> <svg viewbox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"></path></svg></a> <a href="https://www.linkedin.com/in/kak-investment-family-group/" target="_blank"> <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path></svg></a></div>
</div>
</div>
</div>

<header class="site-header" id="masthead">
<div class="logo">
<div class="container">
<div class="row">
<div class="col-6"><a href="https://www.kakifg.com/"><img data-src=" " height="58" src="Gold-Luxury-Initial-Circle-Logo.png" width="320" /></a></div>

<div class="col-6"><a class="phone-number" href="tel:1-800-428-2053">1 800 428 2053</a></div>
</div>
</div>
</div>

<div class="container">
<nav class="navbar navbar-expand-md"><input id="navbar-toggle-cbox" type="checkbox" /> <label class="navbar-toggler collapsed" data-bs-target="#primary-menu-container" data-bs-toggle="collapse" for="navbar-toggle-cbox"> </label> <a class="button d-md-none" href="https://www.kakifg.com/get-a-quote/">Get a Quote</a>

<div class="collapse navbar-collapse" id="primary-menu-container">
<ul class="navbar-nav" id="primary-menu">
	<li class="nav-item  menu-item menu-item-type-custom menu-item-object-custom"><a class="nav-link" href="https://www.kakifg.com/">Note Buyers</a></li>
	<li class="nav-item  menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children"><a class="nav-link" href="#">Services</a>
	<ul class="sub-menu">
		<li class="nav-item  menu-item menu-item-type-post_type menu-item-object-page"><a class="nav-link" href="https://www.kakifg.com/sell-mortgage-note/">Sell Mortgage Notes</a></li>
		<li class="nav-item  menu-item menu-item-type-post_type menu-item-object-page"><a class="nav-link" href="https://www.kakifg.com/sell-business-note/">Sell Business Note</a></li>
		<li class="nav-item  menu-item menu-item-type-post_type menu-item-object-page"><a class="nav-link" href="https://www.kakifg.com/sell-mortgage-portfolio/">Sell Note Portfolio</a></li>
		<li class="nav-item  menu-item menu-item-type-post_type menu-item-object-page"><a class="nav-link" href="https://www.kakifg.com/second-position-note-buyer/">Sell 2nd Mortgage</a></li>
		<li class="nav-item  menu-item menu-item-type-post_type menu-item-object-page"><a class="nav-link" href="https://www.kakifg.com/what-is-a-hypothecation-loan/">Hypothecation Loan</a></li>
	</ul>
	</li>
	<li class="nav-item  menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children"><a class="nav-link" href="https://www.kakifg.com/what-we-buy/">Learn More</a>
	<ul class="sub-menu">
		<li class="nav-item  menu-item menu-item-type-post_type menu-item-object-post"><a class="nav-link" href="https://www.kakifg.com/what-is-a-mortgage-note/">What Is A Mortgage Note?</a></li>
		<li class="nav-item  menu-item menu-item-type-post_type menu-item-object-page"><a class="nav-link" href="https://www.kakifg.com/what-we-buy/">What We Buy</a></li>
		<li class="nav-item  menu-item menu-item-type-post_type menu-item-object-page"><a class="nav-link" href="https://www.kakifg.com/faq/">Frequently Asked Questions</a></li>
		<li class="nav-item  menu-item menu-item-type-post_type menu-item-object-page"><a class="nav-link" href="https://www.kakifg.com/about/">About KAK Investment Fam</a></li>
		<li class="nav-item  menu-item menu-item-type-post_type menu-item-object-page"><a class="nav-link" href="https://www.kakifg.com/recent-transactions/">Recent Transactions</a></li>
	</ul>
	</li>
	<li class="nav-item  menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children"><a class="nav-link" href="https://www.kakifg.com/owner-finance-tips/">Seller Tips</a>
	<ul class="sub-menu">
		<li class="nav-item  menu-item menu-item-type-post_type menu-item-object-page"><a class="nav-link" href="https://www.kakifg.com/owner-finance-tips/">Owner Finance Tips (2023)</a></li>
		<li class="nav-item  menu-item menu-item-type-post_type menu-item-object-page"><a class="nav-link" href="https://www.kakifg.com/create-a-valuable-business-note/">Create Business Notes</a></li>
		<li class="nav-item  menu-item menu-item-type-custom menu-item-object-custom"><a class="nav-link" href="https://www.kakifg.com/wp-content/uploads/2014/12/Note-Seller-Handbook.pdf">Note Seller Handbook</a></li>
	</ul>
	</li>
	<li class="nav-item  menu-item menu-item-type-post_type menu-item-object-page"><a class="nav-link" href="https://www.kakifg.com/blog/">Blog</a></li>
	<li class="nav-item  menu-item menu-item-type-post_type menu-item-object-page"><a class="nav-link" href="https://www.kakifg.com/contact-us/">Contact Us</a></li>
	<li class="nav-item button menu-item menu-item-type-post_type menu-item-object-page"><a class="nav-link" href="https://www.kakifg.com/get-a-quote/">Get a Quote</a></li>
</ul>
</div>
</nav>
</div>
</header>

<div class="page-title lazyloaded">
<div class="container">
<div class="vertical-center">
<div class="row">
<div class="col">
<h1>Mortgage Note Quote</h1>
</div>

<div class="col-md-7">
<p>Our purpose is to leave every situation better than we found.</p>
</div>
</div>
</div>
</div>
</div>

<div class="breadcrumbs">
<div class="container">
<p><span><span><a href="https://www.kakifg.com/">Home</a> &gt; <strong aria-current="page" class="breadcrumb_last">Mortgage Note Quote</strong></span></span></p>
</div>
</div>

<section class="wysiwyg">
<div class="container">
<div class="row justify-content-center">
<div class="col-md-12"></div>
</div>
</div>
</section>


    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
   
    <form method="POST">
    <div class="main-form">
        <div class="info">
            <div class="heading">
                <div class="bullet"><img clas="bullet-img" src="images/bullet.png"></div>
                <div>CONTACT INFORMATION</div>
            </div>

            <div class="form">
                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Full Name*</p>
                    </div>

                    <div class="sub-div-2">
                        <div class="sub">
                            <div>
                                <input type="text" name="First" required class="input-field1">
                                <p class="sub-text">First</p>
                            </div>
                            <div>
                                <input type="text" name="Last" required class="input-field1">
                                <p class="sub-text">Last</p>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Phone Number*</p>
                    </div>
                    <div class="sub-div-2">
                        <input type="text" name="Phone_Number" required class="input-field1">
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>E-mail*</p>
                    </div>
                    <div class="sub-div-2">
                        <input type="text" name="email" required class="input-field1" placeholder="ex: myname@example.com">
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Your Title*</p>
                    </div>
                    <div class="sub-div-2">
                        <select required class="select-field" name="your_title">
                            <option value=" "> </option>
                            <option value="Note Owner/Note Holder">Note Owner/Note Holder</option>
                            <option value="Note Broker">Note Broker</option>
                            <option value="Real Estate Broker">Real Estate Broker</option>
                            <option value="Mortgage Broker">Mortgage Broker</option>
                            <option value="Attorney">Attorney</option>
                            <option value="Financial Planner">Financial Planner</option>
                            <option value="CPA">CPA</option>
                            <option value="Other">Other</option>

                        </select>
                    </div>

                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Company Name*</p>
                    </div>
                    <div class="sub-div-2">
                        <input type="text" required name="company_name" class="input-field1">
                    </div>
                </div>



            </div>
        </div>


        <div class="info">
            <div class="heading">
                <div class="bullet"><img clas="bullet-img" src="images/bullet.png"></div>
                <div>PROPERTY INFORMATION</div>
            </div>

            <div class="form">
                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Address*</p>
                    </div>

                    <div class="sub-div-2">
                        <div class="new-sub">

                            <div class="sub-2">
                                <div class="sub-3">
                                    <input type="text" name="property_address" required class="input-field1">
                                    <p class="sub-text">Property Address</p>
                                </div>

                                <div class="sub-3">
                                    <input type="text" name="city" required class="input-field1">
                                    <p class="sub-text">City</p>
                                </div>
                            </div>

                            <div class="sub-2">
                                <div class="sub-3">
                                <select required name="state" class="select-field">
                                    <option value=" "> </option>
                                    <option value="AL">Alabama</option>
                                    <option value="AK">Alaska</option>
                                    <option value="AZ">Arizona</option>
                                    <option value="AR">Arkansas</option>
                                    <option value="CA">California</option>
                                    <option value="CO">Colorado</option>
                                    <option value="CT">Connecticut</option>
                                    <option value="DE">Delaware</option>
                                    <option value="DC">District Of Columbia</option>
                                    <option value="FL">Florida</option>
                                    <option value="GA">Georgia</option>
                                    <option value="HI">Hawaii</option>
                                    <option value="ID">Idaho</option>
                                    <option value="IL">Illinois</option>
                                    <option value="IN">Indiana</option>
                                    <option value="IA">Iowa</option>
                                    <option value="KS">Kansas</option>
                                    <option value="KY">Kentucky</option>
                                    <option value="LA">Louisiana</option>
                                    <option value="ME">Maine</option>
                                    <option value="MD">Maryland</option>
                                    <option value="MA">Massachusetts</option>
                                    <option value="MI">Michigan</option>
                                    <option value="MN">Minnesota</option>
                                    <option value="MS">Mississippi</option>
                                    <option value="MO">Missouri</option>
                                    <option value="MT">Montana</option>
                                    <option value="NE">Nebraska</option>
                                    <option value="NV">Nevada</option>
                                    <option value="NH">New Hampshire</option>
                                    <option value="NJ">New Jersey</option>
                                    <option value="NM">New Mexico</option>
                                    <option value="NY">New York</option>
                                    <option value="NC">North Carolina</option>
                                    <option value="ND">North Dakota</option>
                                    <option value="OH">Ohio</option>
                                    <option value="OK">Oklahoma</option>
                                    <option value="OR">Oregon</option>
                                    <option value="PA">Pennsylvania</option>
                                    <option value="RI">Rhode Island</option>
                                    <option value="SC">South Carolina</option>
                                    <option value="SD">South Dakota</option>
                                    <option value="TN">Tennessee</option>
                                    <option value="TX">Texas</option>
                                    <option value="UT">Utah</option>
                                    <option value="VT">Vermont</option>
                                    <option value="VA">Virginia</option>
                                    <option value="WA">Washington</option>
                                    <option value="WV">West Virginia</option>
                                    <option value="WI">Wisconsin</option>
                                    <option value="WY">Wyoming</option>
                                </select>
                                <p class="sub-text">State</p>
                                </div>
                                
                                

                                <div class="sub-3">
                                <input required name="zip_code" type="text" class="input-field1">
                                <p class="sub-text">Zip Code</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Property Value*</p>
                    </div>
                    <div class="sub-div-2">
                        <input name="property_value" required type="text" class="input-field1" placeholder="$">
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>When Was Value Established*</p>
                    </div>
                    <div class="sub-div-2">
                        <input type="date" required name="establishment" class="input-field1" >
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>How Was Value Established*</p>
                    </div>
                    <div class="sub-div-2">
                    <select name="input_11" required id="input_9_11" class="select-field" aria-required="true" aria-invalid="false">
                        <option value="" selected="selected"></option>
                        <option value="Property Sale">Property Sale</option>
                        <option value="Appraisal">Appraisal</option>
                        <option value="BPO (Broker Pricing Opinion)">BPO (Broker Pricing Opinion)</option>
                        <option value="TKAK Assessor Office">TKAK Assessor Office</option>
                        <option value="Realtor">Realtor</option>
                        <option value="Speculation">Speculation</option>
                        <option value="Other">Other</option>
                        <option value=""></option></select>
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Any Other Liens on Property*</p>
                    </div>
                    <div class="sub-div-2">
                        <select required name="liens" class="select-field">
                            <option value=" "> </option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Is Property Owner Occupied*</p>
                    </div>
                    <div class="sub-div-2">
                        <select required name="property_owner" class="select-field">
                        <option value=""></option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                </div>

             

            

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Is Land Included*</p>
                    </div>
                    <div class="sub-div-2">
                        <select required name="land_inc" class="select-field">
                            <option value=" "> </option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Land Plot Size*</p>
                    </div>
                    <div class="sub-div-2">
                        <input required name="land_plot" type="text" class="input-field1">
                    </div>
                </div>

 

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Additional Property Details</p>
                    </div>
                    <div class="sub-div-2">
                        <textarea class="multiline-input" name="additional_details" cols="30" rows="12"></textarea>
                    </div>
                </div>

            </div>
        </div>




        <div class="info">
            <div class="heading">
                <div class="bullet"><img clas="bullet-img" src="images/bullet.png"></div>
                <div>SALE INFORMATION</div>
            </div>


            <div class="form">
                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Date of Sale*</p>
                    </div>
                    <div class="sub-div-2">
                        <input required type="date" class="input-field1" name="date_of_sale">
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Sales Price*</p>
                    </div>
                    <div class="sub-div-2">
                        <input type="text" required class="input-field1" placeholder="$" name="sales_price">
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Down Payment*</p>
                    </div>
                    <div class="sub-div-2">
                        <input type="text" required class="input-field1" name="down_payment" placeholder="$">
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Did You Use an Attorney or Title Company to Close*</p>
                    </div>
                    <div class="sub-div-2">
                        <select required class="select-field" name="attorney">
                            <option value=" "> </option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                            <option value="I Don't Know">I Don't Know</option>
                        </select>
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Do You have Title Policy*</p>
                    </div>
                    <div class="sub-div-2">
                        <select required class="select-field" name="has_title_policy">
                            <option value=" "> </option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                            <option value="I Don't Know">I Don't Know</option>
                        </select>
                    </div>
                </div>

            </div>
        </div>



        <div class="info">
            <div class="heading">
                <div class="bullet"><img clas="bullet-img" src="images/bullet.png"></div>
                <div>NOTE INFORMATION</div>
            </div>

            <div class="form">

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Original Note Amount*</p>
                    </div>
                    <div class="sub-div-2">
                        <input required type="text" class="input-field1" placeholder="$" name="note_amount">
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Position of Note*</p>
                    </div>
                    <div class="sub-div-2">
                        <select required name="position_note" class="select-field">
                            <option value=" "> </option>
                            <option value="1st">1st</option>
                            <option value="2nd">2nd</option>
                            <option value="3rd">3rd</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Note Balance*</p>
                    </div>
                    <div class="sub-div-2">
                        <input required type="text" name="note_balance" class="input-field1" placeholder="$">
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Interest Rate*</p>
                    </div>
                    <div class="sub-div-2">
                        <input required type="text" name="interest_rate" class="input-field1" placeholder="%">
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Payment Amount*</p>
                    </div>
                    <div class="sub-div-2">
                        <input required type="text" name="payment_amount" class="input-field1" placeholder="$">
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Date of 1st Payment*</p>
                    </div>
                    <div class="sub-div-2">
                        <input required type="date" name="date_first" class="input-field1">
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Payment Frequency*</p>
                    </div>
                    <div class="sub-div-2">
                        <select required name="payment_frequency" class="select-field">
                            <option value=" "> </option>
                            <option value="Monthly">Monthly</option>
                            <option value="Quaterly">Quaterly</option>
                            <option value="Semi-Annually">Semi-Annually</option>
                            <option value="Annually">Annually</option>
                            <option value="One Time Balloon Payment">One Time Balloon Payment</option>
                        </select>
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Original Length*</p>
                    </div>
                    <div class="sub-div-2">
                        <input required name="orginal_length" type="text" class="input-field1">
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>No. of Payments Made*</p>
                    </div>
                    <div class="sub-div-2">
                        <input name="payment_made" required type="text" class="input-field1">
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>No. of Payments Remaining*</p>
                    </div>
                    <div class="sub-div-2">
                        <input type="text" class="input-field1" required name="payment_remaining">
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Next Payment Due Date*</p>
                    </div>
                    <div class="sub-div-2">
                        <input type="date" class="input-field1" required name="next_due_date">
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Are Payments On Time*</p>
                    </div>
                    <div class="sub-div-2">
                        <select required class="select-field" name="title_policy">
                            <option value=" "> </option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Balloon Amount</p>
                    </div>
                    <div class="sub-div-2">
                        <input type="text" name="balloon_amount" class="input-field1">
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Balloon Due Date</p>
                    </div>
                    <div class="sub-div-2">
                        <input type="date" class="input-field1" name="ballon_date">
                    </div>
                </div>


            </div>
        </div>





        <div class="info">
            <div class="heading">
                <div class="bullet"><img clas="bullet-img" src="images/bullet.png"></div>
                <div>BORROWER INFORMATION</div>
            </div>

            <div class="form">
                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Borrower Type*</p>
                    </div>
                    <div class="sub-div-2">
                        <select required class="select-field" name="borrower_type">
                        <option value="" selected="selected"></option>
                        <option value="Private Individual(s)">Private Individual(s)</option>
                        <option value="Corporate Entity (LLC, etc)">Corporate Entity (LLC, etc)</option>
                        <option value="Government Entity">Government Entity</option>
                        <option value="Trust">Trust</option>
                        <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Borrower Name(s)</p>
                    </div>
                    <div class="sub-div-2">
                        <input type="text" name="borrower_name" class="input-field1">
                    </div>

                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Did You Pull a Credit Report at Sale*</p>
                    </div>
                    <div class="sub-div-2">
                        <select required name="credit_report" class="select-field">
                            <option value=" "> </option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                            <option value="I Don't Know">I Don't Know</option>
                        </select>
                    </div>

                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Borrower Credit Rating*</p>
                    </div>
                    <div class="sub-div-2">
                        <select required name="credit_range" class="select-field">
                        <option value="" selected="selected"></option>
<option value="850 to 801 (Perfect)">850 to 801 (Perfect)</option>
<option value="800 to 751 (Excellent)">800 to 751 (Excellent)</option>
<option value="750 to 701 (Great)">750 to 701 (Great)</option>
<option value="700 to 651 (Good)">700 to 651 (Good)</option>
<option value="650 to 601 (Average)">650 to 601 (Average)</option>
<option value="600 to 551 (Poor)">600 to 551 (Poor)</option>
<option value="550 or Lower (Extremely Poor)">550 or Lower (Extremely Poor)</option>
<option value="I did not pull a credit report">I did not pull a credit report</option>
<option value="I don't know">I don't know</option>
                        </select>
                    </div>

                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Borrower Employment</p>
                    </div>
                    <div class="sub-div-2"><input type="text" name="borrower" class="input-field1"></div>
                </div>

                <div class="main-div">
                    <div class="sub-div-1">
                        <p>Additional Information</p>
                    </div>
                    <div class="sub-div-2"><textarea name="additional_info" class="multiline-input" cols="30" rows="12"></textarea></div>
                </div>

            </div>
        </div>


        <div class="submit">
            <button name="submit" class="submit-btn1">SUBMIT</button>
        </div>
        </form>


    </div>




    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s"
        crossorigin="anonymous"></script>
        
        <script nitro-exclude="">document.cookie = 'nitroCachedPage=' + (!window.NITROPACK_STATE ? '0' : '1') + '; path=/';</script><script nitro-exclude="">if (!window.NITROPACK_STATE || window.NITROPACK_STATE != 'FRESH') {
        var proxyPurgeOnly = 0;
        if (typeof navigator.sendBeacon !== 'undefined') {
            var nitroData = new FormData(); nitroData.append('nitroBeaconUrl', 'aHR0cHM6Ly93d3cuYW1lcmlub3RleGNoYW5nZS5jb20vbW9ydGdhZ2Utbm90ZS1xdW90ZS8='); nitroData.append('nitroBeaconCookies', 'W10='); nitroData.append('nitroBeaconHash', 'd5d2aa0d4a24530e094c7d4532d03a019362dc65e3988e5a0f273f40a2e8f42f3daaf6e6c6d2c5fb7f8773f0974a71a3cea1a32a05294f5b4a12fc75c067859a'); nitroData.append('proxyPurgeOnly', ''); nitroData.append('layout', 'page'); navigator.sendBeacon(location.href, nitroData);
        } else {
            var xhr = new XMLHttpRequest(); xhr.open('POST', location.href, true); xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); xhr.send('nitroBeaconUrl=aHR0cHM6Ly93d3cuYW1lcmlub3RleGNoYW5nZS5jb20vbW9ydGdhZ2Utbm90ZS1xdW90ZS8=&nitroBeaconCookies=W10=&nitroBeaconHash=d5d2aa0d4a24530e094c7d4532d03a019362dc65e3988e5a0f273f40a2e8f42f3daaf6e6c6d2c5fb7f8773f0974a71a3cea1a32a05294f5b4a12fc75c067859a&proxyPurgeOnly=&layout=page');
        }
    }</script>

<footer class="nitro-offscreen">
<div class="container">
<div class="row">
<div class="col-md-4 logo-about"><a href="https://www.kakifg.com/"><img data-src=" " height="58" src="Gold-Luxury-Initial-Circle-Logo.png" width="320" /></a>

<p>KAK Investment Family is an independent private money loan acquisisions sourcing agent based in Decatur, Alabama. The primary business is the purchase and trade of discount private mortgage paper nationwide..</p>

<div class="reviews">
<div class="row">
<div class="col"><noscript></noscript></div>

<div class="col text-right"><noscript><img src="google-stars-1.png"></noscript><img class="lazyload nitro-lazy" data-src="https://cdn-gockj.nitrocdn.com/TUhivPxGWeGmWssrgYNAyVtQiuMbtdLS/assets/static/optimized/wp-content/uploads/2022/11/1f70c72dc09e7bb7dc752a4845176cf5.google-stars-1.png" decoding="async" id="MzI6MTQxMg==-1" nitro-lazy-empty="" nitro-lazy-src="https://cdn-gockj.nitrocdn.com/TUhivPxGWeGmWssrgYNAyVtQiuMbtdLS/assets/static/optimized/wp-content/uploads/2022/11/1f70c72dc09e7bb7dc752a4845176cf5.google-stars-1.png" src="edbea1ada5c320459a6036eaba1fc57a1a04e7fc.svg" /> <span>42 reviews, 4.9 stars</span></div>
</div>
</div>

<div class="social-icons dark-hover"><a href="https://www.facebook.com/KAKInvestmentFamilyGroup" target="_blank"><svg viewbox="0 0 320 512" xmlns="http://www.w3.org/2000/svg"><path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path></svg></a> <a href="https://twitter.com/kak_ifg" target="_blank"><svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg></a> <a href="https://www.youtube.com/channel/UCV6s9G_yhmTquaTPdZ-EOww" target="_blank"><svg viewbox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"></path></svg></a> <a href="https://www.linkedin.com/in/kak-investment-family-group/" target="_blank"><svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path></svg></a></div>
</div>

<div class="col-md-3 posts">
<h3>Blog Posts</h3>

<div class="row">
<div class="col-3">
<div class="date"><span class="day">14</span> <span class="month">Mar</span></div>
</div>

<div class="col-9">
<h6>Do you need title insurance as a lender or home owner?</h6>

<p><a href="https://www.kakifg.com/do-you-need-title-insurance/">Read More</a></p>
</div>
</div>

<div class="row">
<div class="col-3">
<div class="date"><span class="day">15</span> <span class="month">Feb</span></div>
</div>

<div class="col-9">
<h6>Sell future payments</h6>

<p><a href="https://www.kakifg.com/sell-future-payments/">Read More</a></p>
</div>
</div>
</div>

<div class="col-md-2">
<h3>Links</h3>

<div class="menu-footer_navigation_menu-container">
<ul class="menu" id="menu-footer_navigation_menu">
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home menu-item-33543" id="menu-item-33543"><a href="https://www.kakifg.com/">Home</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1074" id="menu-item-1074"><a href="https://www.kakifg.com/about/">About</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1078" id="menu-item-1078"><a href="https://www.kakifg.com/owner-finance-tips/">Seller Tips</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1075" id="menu-item-1075"><a href="https://www.kakifg.com/blog/">KAK Investment Blog</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1076" id="menu-item-1076"><a href="https://www.kakifg.com/contact-us/">Contact</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1105" id="menu-item-1105"><a href="https://www.kakifg.com/sitemap/">KAK Investment Family Sitemap</a></li>
</ul>
</div>
</div>

<div class="col-md-3">
<h3>Contact Info</h3>

<p></p>

<h6><strong>KAK Investment Family Group LLC</strong></h6>
<br />
1212 Byron Ave SW,<br />
Decatur, Al 35601
<p></p>

<p></p>

<h5><a class="phone" href="tel: 1-800-428-2053">1 800 428 2053</a></h5>
<br />
<a href="http://www.bbb.org/us/al/decatur/profile/mortgage-broker/kak-investment-family-group-llc-0513-900275153l"><img alt="BBB Business listing Nonaccredited" data-src="bbb-logo1.png" height="35" src="bbb-logo1.png" title="BBB Business listing Nonaccredited" width="35" /></a>

<p></p>
</div>
</div>
</div>
</footer>
<script nitro-exclude="">(function(){var e=[];var a={};var r=null;var i={enabled:true,observeSelectors:['[class*="slider"]','[id*="slider"]',".fotorama",".esg-grid"],attributes:["src","data-src"],attributeRegex:/^data:image¥/.*?;nitro-empty-id=([^;]*);base64/,cssUrlFuncRegex:/^url¥(['|"]data:image¥/.*?;nitro-empty-id=([^;]*);base64/};var l=function(t){setTimeout(t,0)};var t=function(){document.querySelectorAll("[nitro-lazy-empty]").forEach(function(t){let e=t.getAttribute("nitro-lazy-src");let r=t.getAttribute("id");if(r&&e){a[r]=e}});r=new MutationObserver(n);let e=document.querySelectorAll(i.observeSelectors.join(","));for(let t=0;t<e.length;++t){r.observe(e[t],{subtree:true,childList:true,attributes:true,attributeFilter:i.attributes,characterData:false,attributeOldValue:false,characterDataOldValue:false})}};var n=function(a){for(let r=0;r<a.length;++r){switch(a[r].type){case"attributes":let t=a[r].target.getAttribute(a[r].attributeName);if(!t)break;let e=i.attributeRegex.exec(t);if(e&&e[1]){a[r].target.setAttribute("nitro-lazy-"+a[r].attributeName,u(e[1]));if(a[r].target.className.indexOf("nitro-lazy")<0){a[r].target.className+=" nitro-lazy"}}break;case"childList":if(a[r].addedNodes.length>0){for(let e=0;e<a[r].addedNodes.length;++e){let t=a[r].addedNodes[e];l(function(t){return function(){s(t,true)}}(t))}}break}}};var s=function(a,t){if(!(a instanceof HTMLElement))return;if(e.indexOf(a)>-1)return;for(let r=0;r<i.attributes.length;++r){let e=a.getAttribute(i.attributes[r]);if(e){let t=i.attributeRegex.exec(e);if(t){a.setAttribute("nitro-lazy-"+i.attributes[r],u(t[1]));if(a.className.indexOf("nitro-lazy")<0){a.className+=" nitro-lazy"}}}}if(a.style.backgroundImage){let t=i.cssUrlFuncRegex.exec(a.style.backgroundImage);if(t){a.setAttribute("nitro-lazy-bg",u(t[1]));if(a.className.indexOf("nitro-lazy")<0){a.className+=" nitro-lazy"}}}e.push(a);if(t){a.querySelectorAll("*").forEach(function(t){l(function(){s(t)})})}};function u(t){return a[t]}if(i.enabled){t()}})();</script>

<div class="copyright nitro-offscreen">
<div class="container">
<div class="row">
<div class="col">
<p>Copyright &copy; 2023 KAK Investment Family Group. All Rights Reserved.</p>
</div>
</div>
</div>
</div>
<noscript><style></style></noscript><template data-nitro-marker-id="f6b89c0e0ab5825bc1d97c5bf98f37f3-1"></template><template data-nitro-marker-id="6fdb97986b2486f045bcfbdc78643fec-1"></template><template data-nitro-marker-id="stickThis-js-extra"></template>

<p><template data-nitro-marker-id="regenerator-runtime-js"></template> <template data-nitro-marker-id="wp-polyfill-js"></template> <template data-nitro-marker-id="wp-dom-ready-js"></template> <template data-nitro-marker-id="wp-hooks-js"></template> <template data-nitro-marker-id="wp-i18n-js"></template> <template data-nitro-marker-id="wp-i18n-js-after"></template> <template data-nitro-marker-id="wp-a11y-js"></template> <template data-nitro-marker-id="gform_gravityforms-js-extra"></template> <template data-nitro-marker-id="e06767b8c2b1dab459efc9b997e89aff-1"></template> <template data-nitro-marker-id="3ecb85ede1366d1569bdf2c4ec0dd5df-1"></template> <template data-nitro-marker-id="dbd6df0275b10331c47f3ce6e834e6d4-1"></template><script>NPRL.registerInlineScript("92c1631b0b5bf66c5f934ae7bdd10cb0-1", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6IjkyYzE2MzFiMGI1YmY2NmM1ZjkzNGFlN2JkZDEwY2IwLTEifX0=");NPRL.registerInlineScript("7c99f700325ec31bbc4b2bcfee6c6864-1", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsiaWQiOiI3Yzk5ZjcwMDMyNWVjMzFiYmM0YjJiY2ZlZTZjNjg2NC0xIn19");NPRL.registerInlineScript("df9834de29bed96b040b7a50058d6741-1", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6ImRmOTgzNGRlMjliZWQ5NmIwNDBiN2E1MDA1OGQ2NzQxLTEifX0=");NPRL.registerScript("https://cdn-gockj.nitrocdn.com/TUhivPxGWeGmWssrgYNAyVtQiuMbtdLS/assets/static/optimized/wp-includes/js/jquery/nitro-min-1626d5c96a58d884c520b55e4de657fc.jquery.min.js", "jquery-core-js", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6ImpxdWVyeS1jb3JlLWpzIn19");NPRL.registerInlineScript("aff27d6fdb73523ff9320446b22958f3-1", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6ImFmZjI3ZDZmZGI3MzUyM2ZmOTMyMDQ0NmIyMjk1OGYzLTEifX0=");NPRL.registerInlineScript("f6b89c0e0ab5825bc1d97c5bf98f37f3-1", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsiZGF0YS1ub3B0aW1pemUiOiIxIiwiaWQiOiJmNmI4OWMwZTBhYjU4MjViYzFkOTdjNWJmOThmMzdmMy0xIn19");NPRL.registerInlineScript("stickThis-js-extra", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6InN0aWNrVGhpcy1qcy1leHRyYSJ9fQ==");NPRL.registerScript("https://cdn-gockj.nitrocdn.com/TUhivPxGWeGmWssrgYNAyVtQiuMbtdLS/assets/static/optimized/wp-includes/js/dist/vendor/nitro-min-c80ea1d10063a8846fc99216946ae0de.regenerator-runtime.min.js", "regenerator-runtime-js", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6InJlZ2VuZXJhdG9yLXJ1bnRpbWUtanMifX0=");NPRL.registerScript("https://cdn-gockj.nitrocdn.com/TUhivPxGWeGmWssrgYNAyVtQiuMbtdLS/assets/static/optimized/wp-includes/js/dist/vendor/nitro-min-9b9ef9c56e97fa98cbf2c3c740c1f2e4.wp-polyfill.min.js", "wp-polyfill-js", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6IndwLXBvbHlmaWxsLWpzIn19");NPRL.registerScript("https://cdn-gockj.nitrocdn.com/TUhivPxGWeGmWssrgYNAyVtQiuMbtdLS/assets/static/optimized/wp-includes/js/dist/nitro-min-9d7a1c735580817d3a4189d20b5128e0.dom-ready.min.js", "wp-dom-ready-js", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6IndwLWRvbS1yZWFkeS1qcyJ9fQ==");NPRL.registerScript("https://cdn-gockj.nitrocdn.com/TUhivPxGWeGmWssrgYNAyVtQiuMbtdLS/assets/static/optimized/wp-includes/js/dist/nitro-min-6ba6afbbd332433962a6865d873b8a69.hooks.min.js", "wp-hooks-js", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6IndwLWhvb2tzLWpzIn19");NPRL.registerScript("https://cdn-gockj.nitrocdn.com/TUhivPxGWeGmWssrgYNAyVtQiuMbtdLS/assets/static/optimized/wp-includes/js/dist/nitro-min-f9ef16b206cd2847e69943bb596e3f17.i18n.min.js", "wp-i18n-js", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6IndwLWkxOG4tanMifX0=");NPRL.registerInlineScript("wp-i18n-js-after", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6IndwLWkxOG4tanMtYWZ0ZXIifX0=");NPRL.registerScript("https://cdn-gockj.nitrocdn.com/TUhivPxGWeGmWssrgYNAyVtQiuMbtdLS/assets/static/optimized/wp-includes/js/dist/nitro-min-cdb84cdb4d6c4ded07bd30ce7027e5b3.a11y.min.js", "wp-a11y-js", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6IndwLWExMXktanMifX0=");NPRL.registerInlineScript("gform_gravityforms-js-extra", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6Imdmb3JtX2dyYXZpdHlmb3Jtcy1qcy1leHRyYSJ9fQ==");NPRL.registerInlineScript("e06767b8c2b1dab459efc9b997e89aff-1", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6ImUwNjc2N2I4YzJiMWRhYjQ1OWVmYzliOTk3ZTg5YWZmLTEifX0=");NPRL.registerInlineScript("3ecb85ede1366d1569bdf2c4ec0dd5df-1", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6IjNlY2I4NWVkZTEzNjZkMTU2OWJkZjJjNGVjMGRkNWRmLTEifX0=");NPRL.registerScript("https://cdn-gockj.nitrocdn.com/TUhivPxGWeGmWssrgYNAyVtQiuMbtdLS/assets/static/optimized/wp-content/cache/autoptimize/js/nitro-min-6080873996d19e065657cd8dcff906c2.autoptimize_d46b13a4bf49dbf525d3f17eea8311bf.js", "dbd6df0275b10331c47f3ce6e834e6d4-1", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsiZGVmZXIiOmZhbHNlLCJpZCI6ImRiZDZkZjAyNzViMTAzMzFjNDdmM2NlNmU4MzRlNmQ0LTEifX0=");</script><noscript id="nitro-deferred-styles"><link as="style" nitropack-onload="this.onload=null;this.rel='stylesheet'" onload="NPRL.onLoadStyle(this)" onerror="NPRL.onErrorStyle(this)" href="nitro-min-noimport-c7edace81c5ab0f7dec5b27034f1714e.main.min.css" rel="stylesheet"><style type="text/css" onload="NPRL.onLoadStyle(this)" onerror="NPRL.onErrorStyle(this)"></style><link rel="stylesheet" onload="NPRL.onLoadStyle(this)" onerror="NPRL.onErrorStyle(this)" href="nitro-min-noimport-4101156e54d759d797b61d170b1eb835.8121f7253270160f5170a4759fbe75db-stylesheet.css"><style id="global-styles-inline-css" type="text/css" onload="NPRL.onLoadStyle(this)" onerror="NPRL.onErrorStyle(this)"></style></noscript><script id="nitro-boot-resource-loader">NPRL.boot();</script><script>(function(){let d=Math.mKAK(document.documentElement.clientHeight||0,window.innerHeight||0);let o=[];function f(t){if(t===null)return;let e=null;let n=t.children.length;let i;let l=["SCRIPT","STYLE","LINK","TEMPLATE"];for(let e=0;e<n;e++){i=t.children[e];if(l.indexOf(i.tagName)==-1){let e=i.getBoundingClientRect();if(e.width*e.height>0){if(e.y>d){o.push(i)}else{f(i)}}}}}if(typeof NPRL!=="undefined"){f(document.body);let t=o.length;let n;for(let e=1;e<t;e++){n=o[e];n.classList.add("nitro-offscreen")}let e=false;function i(){if(!e){document.getElementById("nitro-preloader").remove();e=true}}window.addEventListener("NitroStylesLoaded",i);setTimeout(i,3e3)}})();</script></p>

<div aria-live="polite" class="visually-hidden" id="hl-aria-live-message-container"></div>

<div aria-live="assertive" class="visually-hidden" id="hl-aria-live-alert-container" role="alert"></div>
</body>
</html>





    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s"
        crossorigin="anonymous"></script>
        
        <script nitro-exclude="">document.cookie = 'nitroCachedPage=' + (!window.NITROPACK_STATE ? '0' : '1') + '; path=/';</script><script nitro-exclude="">if (!window.NITROPACK_STATE || window.NITROPACK_STATE != 'FRESH') {
        var proxyPurgeOnly = 0;
        if (typeof navigator.sendBeacon !== 'undefined') {
            var nitroData = new FormData(); nitroData.append('nitroBeaconUrl', 'aHR0cHM6Ly93d3cuYW1lcmlub3RleGNoYW5nZS5jb20vbW9ydGdhZ2Utbm90ZS1xdW90ZS8='); nitroData.append('nitroBeaconCookies', 'W10='); nitroData.append('nitroBeaconHash', 'd5d2aa0d4a24530e094c7d4532d03a019362dc65e3988e5a0f273f40a2e8f42f3daaf6e6c6d2c5fb7f8773f0974a71a3cea1a32a05294f5b4a12fc75c067859a'); nitroData.append('proxyPurgeOnly', ''); nitroData.append('layout', 'page'); navigator.sendBeacon(location.href, nitroData);
        } else {
            var xhr = new XMLHttpRequest(); xhr.open('POST', location.href, true); xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); xhr.send('nitroBeaconUrl=aHR0cHM6Ly93d3cuYW1lcmlub3RleGNoYW5nZS5jb20vbW9ydGdhZ2Utbm90ZS1xdW90ZS8=&nitroBeaconCookies=W10=&nitroBeaconHash=d5d2aa0d4a24530e094c7d4532d03a019362dc65e3988e5a0f273f40a2e8f42f3daaf6e6c6d2c5fb7f8773f0974a71a3cea1a32a05294f5b4a12fc75c067859a&proxyPurgeOnly=&layout=page');
        }
    }</script>

<footer class="nitro-offscreen">
<div class="container">
<div class="row">
<div class="col-md-4 logo-about"><a href="https://www.kakifg.com/"><img data-src=" " height="58" src="Gold-Luxury-Initial-Circle-Logo.png" width="320" /></a>

<p>KAK Investment Family is an independent private money loan acquisisions sourcing agent based in Decatur, Alabama. The primary business is the purchase and trade of discount private mortgage paper nationwide..</p>

<div class="reviews">
<div class="row">
<div class="col"><noscript></noscript></div>

<div class="col text-right"><noscript><img src="google-stars-1.png"></noscript><img class="lazyload nitro-lazy" data-src="https://cdn-gockj.nitrocdn.com/TUhivPxGWeGmWssrgYNAyVtQiuMbtdLS/assets/static/optimized/wp-content/uploads/2022/11/1f70c72dc09e7bb7dc752a4845176cf5.google-stars-1.png" decoding="async" id="MzI6MTQxMg==-1" nitro-lazy-empty="" nitro-lazy-src="https://cdn-gockj.nitrocdn.com/TUhivPxGWeGmWssrgYNAyVtQiuMbtdLS/assets/static/optimized/wp-content/uploads/2022/11/1f70c72dc09e7bb7dc752a4845176cf5.google-stars-1.png" src="edbea1ada5c320459a6036eaba1fc57a1a04e7fc.svg" /> <span>42 reviews, 4.9 stars</span></div>
</div>
</div>

<div class="social-icons dark-hover"><a href="https://www.facebook.com/KAKInvestmentFamilyGroup" target="_blank"><svg viewbox="0 0 320 512" xmlns="http://www.w3.org/2000/svg"><path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path></svg></a> <a href="https://twitter.com/kak_ifg" target="_blank"><svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg></a> <a href="https://www.youtube.com/channel/UCV6s9G_yhmTquaTPdZ-EOww" target="_blank"><svg viewbox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"></path></svg></a> <a href="https://www.linkedin.com/in/kak-investment-family-group/" target="_blank"><svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path></svg></a></div>
</div>

<div class="col-md-3 posts">
<h3>Blog Posts</h3>

<div class="row">
<div class="col-3">
<div class="date"><span class="day">14</span> <span class="month">Mar</span></div>
</div>

<div class="col-9">
<h6>Do you need title insurance as a lender or home owner?</h6>

<p><a href="https://www.kakifg.com/do-you-need-title-insurance/">Read More</a></p>
</div>
</div>

<div class="row">
<div class="col-3">
<div class="date"><span class="day">15</span> <span class="month">Feb</span></div>
</div>

<div class="col-9">
<h6>Sell future payments</h6>

<p><a href="https://www.kakifg.com/sell-future-payments/">Read More</a></p>
</div>
</div>
</div>

<div class="col-md-2">
<h3>Links</h3>

<div class="menu-footer_navigation_menu-container">
<ul class="menu" id="menu-footer_navigation_menu">
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home menu-item-33543" id="menu-item-33543"><a href="https://www.kakifg.com/">Home</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1074" id="menu-item-1074"><a href="https://www.kakifg.com/about/">About</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1078" id="menu-item-1078"><a href="https://www.kakifg.com/owner-finance-tips/">Seller Tips</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1075" id="menu-item-1075"><a href="https://www.kakifg.com/blog/">KAK Investment Blog</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1076" id="menu-item-1076"><a href="https://www.kakifg.com/contact-us/">Contact</a></li>
	<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1105" id="menu-item-1105"><a href="https://www.kakifg.com/sitemap/">KAK Investment Family Sitemap</a></li>
</ul>
</div>
</div>

<div class="col-md-3">
<h3>Contact Info</h3>

<p></p>

<h6><strong>KAK Investment Family Group LLC</strong></h6>
<br />
1212 Byron Ave SW,<br />
Decatur, Al 35601
<p></p>

<p></p>

<h5><a class="phone" href="tel: 1-800-428-2053">1 800 428 2053</a></h5>
<br />
<a href="http://www.bbb.org/us/al/decatur/profile/mortgage-broker/kak-investment-family-group-llc-0513-900275153l"><img alt="BBB Business listing Nonaccredited" data-src="bbb-logo1.png" height="35" src="bbb-logo1.png" title="BBB Business listing Nonaccredited" width="35" /></a>

<p></p>
</div>
</div>
</div>
</footer>
<script nitro-exclude="">(function(){var e=[];var a={};var r=null;var i={enabled:true,observeSelectors:['[class*="slider"]','[id*="slider"]',".fotorama",".esg-grid"],attributes:["src","data-src"],attributeRegex:/^data:image\/.*?;nitro-empty-id=([^;]*);base64/,cssUrlFuncRegex:/^url\(['|"]data:image\/.*?;nitro-empty-id=([^;]*);base64/};var l=function(t){setTimeout(t,0)};var t=function(){document.querySelectorAll("[nitro-lazy-empty]").forEach(function(t){let e=t.getAttribute("nitro-lazy-src");let r=t.getAttribute("id");if(r&&e){a[r]=e}});r=new MutationObserver(n);let e=document.querySelectorAll(i.observeSelectors.join(","));for(let t=0;t<e.length;++t){r.observe(e[t],{subtree:true,childList:true,attributes:true,attributeFilter:i.attributes,characterData:false,attributeOldValue:false,characterDataOldValue:false})}};var n=function(a){for(let r=0;r<a.length;++r){switch(a[r].type){case"attributes":let t=a[r].target.getAttribute(a[r].attributeName);if(!t)break;let e=i.attributeRegex.exec(t);if(e&&e[1]){a[r].target.setAttribute("nitro-lazy-"+a[r].attributeName,u(e[1]));if(a[r].target.className.indexOf("nitro-lazy")<0){a[r].target.className+=" nitro-lazy"}}break;case"childList":if(a[r].addedNodes.length>0){for(let e=0;e<a[r].addedNodes.length;++e){let t=a[r].addedNodes[e];l(function(t){return function(){s(t,true)}}(t))}}break}}};var s=function(a,t){if(!(a instanceof HTMLElement))return;if(e.indexOf(a)>-1)return;for(let r=0;r<i.attributes.length;++r){let e=a.getAttribute(i.attributes[r]);if(e){let t=i.attributeRegex.exec(e);if(t){a.setAttribute("nitro-lazy-"+i.attributes[r],u(t[1]));if(a.className.indexOf("nitro-lazy")<0){a.className+=" nitro-lazy"}}}}if(a.style.backgroundImage){let t=i.cssUrlFuncRegex.exec(a.style.backgroundImage);if(t){a.setAttribute("nitro-lazy-bg",u(t[1]));if(a.className.indexOf("nitro-lazy")<0){a.className+=" nitro-lazy"}}}e.push(a);if(t){a.querySelectorAll("*").forEach(function(t){l(function(){s(t)})})}};function u(t){return a[t]}if(i.enabled){t()}})();</script>

<div class="copyright nitro-offscreen">
<div class="container">
<div class="row">
<div class="col">
<p>Copyright &copy; 2023 KAK Investment Family Group. All Rights Reserved.</p>
</div>
</div>
</div>
</div>
<noscript><style></style></noscript><template data-nitro-marker-id="f6b89c0e0ab5825bc1d97c5bf98f37f3-1"></template><template data-nitro-marker-id="6fdb97986b2486f045bcfbdc78643fec-1"></template><template data-nitro-marker-id="stickThis-js-extra"></template>

<p><template data-nitro-marker-id="regenerator-runtime-js"></template> <template data-nitro-marker-id="wp-polyfill-js"></template> <template data-nitro-marker-id="wp-dom-ready-js"></template> <template data-nitro-marker-id="wp-hooks-js"></template> <template data-nitro-marker-id="wp-i18n-js"></template> <template data-nitro-marker-id="wp-i18n-js-after"></template> <template data-nitro-marker-id="wp-a11y-js"></template> <template data-nitro-marker-id="gform_gravityforms-js-extra"></template> <template data-nitro-marker-id="e06767b8c2b1dab459efc9b997e89aff-1"></template> <template data-nitro-marker-id="3ecb85ede1366d1569bdf2c4ec0dd5df-1"></template> <template data-nitro-marker-id="dbd6df0275b10331c47f3ce6e834e6d4-1"></template><script>NPRL.registerInlineScript("92c1631b0b5bf66c5f934ae7bdd10cb0-1", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6IjkyYzE2MzFiMGI1YmY2NmM1ZjkzNGFlN2JkZDEwY2IwLTEifX0=");NPRL.registerInlineScript("7c99f700325ec31bbc4b2bcfee6c6864-1", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsiaWQiOiI3Yzk5ZjcwMDMyNWVjMzFiYmM0YjJiY2ZlZTZjNjg2NC0xIn19");NPRL.registerInlineScript("df9834de29bed96b040b7a50058d6741-1", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6ImRmOTgzNGRlMjliZWQ5NmIwNDBiN2E1MDA1OGQ2NzQxLTEifX0=");NPRL.registerScript("https://cdn-gockj.nitrocdn.com/TUhivPxGWeGmWssrgYNAyVtQiuMbtdLS/assets/static/optimized/wp-includes/js/jquery/nitro-min-1626d5c96a58d884c520b55e4de657fc.jquery.min.js", "jquery-core-js", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6ImpxdWVyeS1jb3JlLWpzIn19");NPRL.registerInlineScript("aff27d6fdb73523ff9320446b22958f3-1", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6ImFmZjI3ZDZmZGI3MzUyM2ZmOTMyMDQ0NmIyMjk1OGYzLTEifX0=");NPRL.registerInlineScript("f6b89c0e0ab5825bc1d97c5bf98f37f3-1", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsiZGF0YS1ub3B0aW1pemUiOiIxIiwiaWQiOiJmNmI4OWMwZTBhYjU4MjViYzFkOTdjNWJmOThmMzdmMy0xIn19");NPRL.registerInlineScript("stickThis-js-extra", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6InN0aWNrVGhpcy1qcy1leHRyYSJ9fQ==");NPRL.registerScript("https://cdn-gockj.nitrocdn.com/TUhivPxGWeGmWssrgYNAyVtQiuMbtdLS/assets/static/optimized/wp-includes/js/dist/vendor/nitro-min-c80ea1d10063a8846fc99216946ae0de.regenerator-runtime.min.js", "regenerator-runtime-js", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6InJlZ2VuZXJhdG9yLXJ1bnRpbWUtanMifX0=");NPRL.registerScript("https://cdn-gockj.nitrocdn.com/TUhivPxGWeGmWssrgYNAyVtQiuMbtdLS/assets/static/optimized/wp-includes/js/dist/vendor/nitro-min-9b9ef9c56e97fa98cbf2c3c740c1f2e4.wp-polyfill.min.js", "wp-polyfill-js", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6IndwLXBvbHlmaWxsLWpzIn19");NPRL.registerScript("https://cdn-gockj.nitrocdn.com/TUhivPxGWeGmWssrgYNAyVtQiuMbtdLS/assets/static/optimized/wp-includes/js/dist/nitro-min-9d7a1c735580817d3a4189d20b5128e0.dom-ready.min.js", "wp-dom-ready-js", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6IndwLWRvbS1yZWFkeS1qcyJ9fQ==");NPRL.registerScript("https://cdn-gockj.nitrocdn.com/TUhivPxGWeGmWssrgYNAyVtQiuMbtdLS/assets/static/optimized/wp-includes/js/dist/nitro-min-6ba6afbbd332433962a6865d873b8a69.hooks.min.js", "wp-hooks-js", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6IndwLWhvb2tzLWpzIn19");NPRL.registerScript("https://cdn-gockj.nitrocdn.com/TUhivPxGWeGmWssrgYNAyVtQiuMbtdLS/assets/static/optimized/wp-includes/js/dist/nitro-min-f9ef16b206cd2847e69943bb596e3f17.i18n.min.js", "wp-i18n-js", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6IndwLWkxOG4tanMifX0=");NPRL.registerInlineScript("wp-i18n-js-after", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6IndwLWkxOG4tanMtYWZ0ZXIifX0=");NPRL.registerScript("https://cdn-gockj.nitrocdn.com/TUhivPxGWeGmWssrgYNAyVtQiuMbtdLS/assets/static/optimized/wp-includes/js/dist/nitro-min-cdb84cdb4d6c4ded07bd30ce7027e5b3.a11y.min.js", "wp-a11y-js", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6IndwLWExMXktanMifX0=");NPRL.registerInlineScript("gform_gravityforms-js-extra", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6Imdmb3JtX2dyYXZpdHlmb3Jtcy1qcy1leHRyYSJ9fQ==");NPRL.registerInlineScript("e06767b8c2b1dab459efc9b997e89aff-1", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6ImUwNjc2N2I4YzJiMWRhYjQ1OWVmYzliOTk3ZTg5YWZmLTEifX0=");NPRL.registerInlineScript("3ecb85ede1366d1569bdf2c4ec0dd5df-1", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsidHlwZSI6InRleHRcL2phdmFzY3JpcHQiLCJpZCI6IjNlY2I4NWVkZTEzNjZkMTU2OWJkZjJjNGVjMGRkNWRmLTEifX0=");NPRL.registerScript("https://cdn-gockj.nitrocdn.com/TUhivPxGWeGmWssrgYNAyVtQiuMbtdLS/assets/static/optimized/wp-content/cache/autoptimize/js/nitro-min-6080873996d19e065657cd8dcff906c2.autoptimize_d46b13a4bf49dbf525d3f17eea8311bf.js", "dbd6df0275b10331c47f3ce6e834e6d4-1", "eyJkZWxheSI6ZmFsc2UsImF0dHJpYnV0ZXMiOnsiZGVmZXIiOmZhbHNlLCJpZCI6ImRiZDZkZjAyNzViMTAzMzFjNDdmM2NlNmU4MzRlNmQ0LTEifX0=");</script><noscript id="nitro-deferred-styles"><link as="style" nitropack-onload="this.onload=null;this.rel='stylesheet'" onload="NPRL.onLoadStyle(this)" onerror="NPRL.onErrorStyle(this)" href="nitro-min-noimport-c7edace81c5ab0f7dec5b27034f1714e.main.min.css" rel="stylesheet"><style type="text/css" onload="NPRL.onLoadStyle(this)" onerror="NPRL.onErrorStyle(this)"></style><link rel="stylesheet" onload="NPRL.onLoadStyle(this)" onerror="NPRL.onErrorStyle(this)" href="nitro-min-noimport-4101156e54d759d797b61d170b1eb835.8121f7253270160f5170a4759fbe75db-stylesheet.css"><style id="global-styles-inline-css" type="text/css" onload="NPRL.onLoadStyle(this)" onerror="NPRL.onErrorStyle(this)"></style></noscript><script id="nitro-boot-resource-loader">NPRL.boot();</script><script>(function(){let d=Math.mKAK(document.documentElement.clientHeight||0,window.innerHeight||0);let o=[];function f(t){if(t===null)return;let e=null;let n=t.children.length;let i;let l=["SCRIPT","STYLE","LINK","TEMPLATE"];for(let e=0;e<n;e++){i=t.children[e];if(l.indexOf(i.tagName)==-1){let e=i.getBoundingClientRect();if(e.width*e.height>0){if(e.y>d){o.push(i)}else{f(i)}}}}}if(typeof NPRL!=="undefined"){f(document.body);let t=o.length;let n;for(let e=1;e<t;e++){n=o[e];n.classList.add("nitro-offscreen")}let e=false;function i(){if(!e){document.getElementById("nitro-preloader").remove();e=true}}window.addEventListener("NitroStylesLoaded",i);setTimeout(i,3e3)}})();</script></p>

<div aria-live="polite" class="visually-hidden" id="hl-aria-live-message-container"></div>

<div aria-live="assertive" class="visually-hidden" id="hl-aria-live-alert-container" role="alert"></div>
</body>
</html>
