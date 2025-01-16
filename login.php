<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>SMARTCELL</title>
    <link rel="apple-touch-icon" sizes="57x57" href="./assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="./assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="./assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="./assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="./assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="./assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="./assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="./assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="./assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="./assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="./assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendors styles-->
    <link rel="stylesheet" href="./vendors/simplebar/css/simplebar.css">
    <link rel="stylesheet" href="./assets/css/vendors/simplebar.css">
    <!-- Main styles for this application-->
    <link href="./assets/css/style.css" rel="stylesheet">
    <!-- We use those styles to show code examples, you should remove them in your application.-->
    <!--link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism.css"-->
    <link rel="stylesheet" type="text/css" href="./assets/bootstrap-icons/bootstrap-icons.css">
    <script type="text/javascript" src="./assets/jquery/jquery.min.js"></script>
    <style>
      .btn-sub{
        border-radius:0px;
        border:2px solid white;background:transparent !important;
      }
      .btn-sub:hover, .btn-sub.animate {
        background: transparent;
        border-color: #ff0000;
        color: #ff0000;
        animation: color-change 0.6s ease-in-out infinite;
      }

      @keyframes color-change {
        0% {
          border-color: #cccccc;
          color: #cccccc;
        }
        50% {
          border-color: #ff0000;
          color: #ff0000;
        }
        100% {
          border-color: #cccccc;
          color: #cccccc;
        }
      }
    </style>
  </head>
  <body>
<?php ob_start();session_start(); if(!isset($_SESSION["user_id"])):?>
<div class="bg-light min-vh-100 d-flex flex-row align-items-center bg-dark">
<div class="container">
<div class="row justify-content-center">
<div class="col-lg-6" style="-webkit-box-shadow: 0px 0px 44px 0px rgba(255,0,0,0.67);
-moz-box-shadow: 0px 0px 44px 0px rgba(255,0,0,0.67);
box-shadow: 0px 0px 44px 0px rgba(255,0,0,0.67);border-radius:15px;">
<div class="card-group d-block d-md-flex row bg-black" style="-webkit-box-shadow: 0px 0px 44px 0px rgba(255,0,0,0.67);
-moz-box-shadow: 0px 0px 44px 0px rgba(255,0,0,0.67);
box-shadow: 0px 0px 44px 0px rgba(255,0,0,0.67);border-radius:15px;">
<div class="card col-md-12 p-4 mb-0 bg-black" style="-webkit-box-shadow: 0px 0px 44px 0px rgba(255,0,0,0.67);
-moz-box-shadow: 0px 0px 44px 0px rgba(255,0,0,0.67);
box-shadow: 0px 0px 44px 0px rgba(255,0,0,0.67);border-radius:15px;">
<div class="card-body bg-black" >
 <svg xmlns:mydata="http://www.w3.org/2000/svg"  mydata:contrastcolor="ffffff" mydata:template="BlackAndHighlightColorHex1" mydata:presentation="2.5" mydata:layouttype="undefined" mydata:specialfontid="undefined" mydata:id1="436" mydata:id2="1035" mydata:companyname="SMARTCELL" mydata:companytagline="" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 150 550 200"><g fill="#f93822" fill-rule="none" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g data-paper-data="{&quot;isGlobalGroup&quot;:true,&quot;bounds&quot;:{&quot;x&quot;:65,&quot;y&quot;:203.72886534935833,&quot;width&quot;:420,&quot;height&quot;:62.54226930128334}}"><g data-paper-data="{&quot;isPrimaryText&quot;:true}"><path d="M65,265.45834c18.5659,0 28.36219,-6.41679 28.36219,-16.85476c0,-8.29904 -6.97291,-14.07415 -12.10634,-18.22367c-3.93563,-3.16561 -7.01569,-5.43288 -7.01569,-9.06906c0,-4.23508 3.33673,-8.64127 16.21308,-8.64127v-7.61459c-17.32532,0 -24.34101,7.57181 -24.34101,16.12752c0,7.44347 5.60399,11.978 10.01019,15.52862c4.83398,3.85007 9.11184,7.35791 9.11184,11.72133c0,5.86066 -6.16011,8.81239 -20.23426,8.81239z" data-paper-data="{&quot;glyphName&quot;:&quot;S&quot;,&quot;glyphIndex&quot;:0,&quot;firstGlyphOfWord&quot;:true,&quot;word&quot;:1}" fill-rule="nonzero"></path><path d="M161.67957,264.945v-59.89h-7.74292l-20.53371,46.54308h-0.25667l-20.57649,-46.54308h-7.7857v59.89h8.12793v-39.69851h0.25667l17.23976,39.18517h5.73233l17.15421,-39.18517h0.25667v39.69851z" data-paper-data="{&quot;glyphName&quot;:&quot;M&quot;,&quot;glyphIndex&quot;:1,&quot;word&quot;:1}" fill-rule="nonzero"></path><path d="M209.63435,264.945h8.3846l-21.81707,-59.89h-5.13343l-22.03096,59.89h8.51294l15.95641,-43.93359h0.25667z" data-paper-data="{&quot;glyphName&quot;:&quot;&quot;,&quot;glyphIndex&quot;:2,&quot;word&quot;:1}" fill-rule="nonzero"></path><path d="M310.63455,205.055h-42.13689v7.61459h16.98309v52.27541h8.12793v-52.27541h17.02587z" data-paper-data="{&quot;glyphName&quot;:&quot;T&quot;,&quot;glyphIndex&quot;:4,&quot;word&quot;:1}" fill-rule="nonzero"></path><path d="M355.33815,214.46629l3.12284,-6.67346c-4.06396,-2.48116 -9.62518,-4.06396 -15.5714,-4.06396c-17.53921,0 -30.88613,14.45916 -30.88613,30.75779c0,17.28254 13.34691,31.78448 30.88613,31.78448c6.20289,0 11.84966,-1.83948 16.59809,-5.00509l-3.85007,-6.37401c-3.5934,2.56671 -7.95681,3.46506 -12.74801,3.46506c-13.04746,0 -22.7582,-11.07965 -22.7582,-23.87044c0,-11.80689 9.62518,-22.84376 22.7582,-22.84376c4.57731,0 8.89794,0.68446 12.44856,2.82339z" data-paper-data="{&quot;glyphName&quot;:&quot;C&quot;,&quot;glyphIndex&quot;:5,&quot;word&quot;:1}" fill-rule="nonzero"></path><path d="M401.32512,212.66959v-7.61459h-32.76838v59.89h32.76838v-7.61459h-24.64046v-19.12202h22.45875v-7.48625h-22.45875v-18.05256z" data-paper-data="{&quot;glyphName&quot;:&quot;E&quot;,&quot;glyphIndex&quot;:6,&quot;word&quot;:1}" fill-rule="nonzero"></path><path d="M418.99267,257.33041v-52.27541h-8.12793v59.89h33.41006v-7.61459z" data-paper-data="{&quot;glyphName&quot;:&quot;L&quot;,&quot;glyphIndex&quot;:7,&quot;word&quot;:1}" fill-rule="nonzero"></path><path d="M459.71787,257.33041v-52.27541h-8.12793v59.89h33.41006v-7.61459z" data-paper-data="{&quot;glyphName&quot;:&quot;L&quot;,&quot;glyphIndex&quot;:8,&quot;lastGlyphOfWord&quot;:true,&quot;word&quot;:1}" fill-rule="nonzero"></path><g data-paper-data="{&quot;isIcon&quot;:&quot;true&quot;,&quot;iconType&quot;:&quot;icon&quot;,&quot;rawIconId&quot;:&quot;166030&quot;,&quot;selectedEffects&quot;:{&quot;container&quot;:&quot;&quot;,&quot;transformation&quot;:&quot;&quot;,&quot;pattern&quot;:&quot;&quot;},&quot;isDetailed&quot;:false,&quot;fillRule&quot;:&quot;evenodd&quot;,&quot;bounds&quot;:{&quot;x&quot;:224.521,&quot;y&quot;:205.055,&quot;width&quot;:44.704000000000036,&quot;height&quot;:59.889999999999986},&quot;iconStyle&quot;:&quot;icon-in-text&quot;,&quot;suitableAsStandaloneIcon&quot;:true}" fill-rule="evenodd"><path d="M269.225,264.945h-44.704v-59.89h17.283c13.432,0 23.229,7.016 23.229,19.635c0,9.711 -6.032,17.925 -16.385,19.55zM227.23962,215.62379v3.67509c5.51263,2.90332 11.02526,1.45166 16.53788,0c5.51263,-1.45166 11.02526,-2.90332 16.53788,0v-3.67509c-5.51263,-2.90332 -11.02526,-1.45166 -16.53788,0c-5.51263,1.45166 -11.02526,2.90332 -16.53788,0zM260.31538,226.64904v-3.67509c-5.51263,-2.90332 -11.02526,-1.45166 -16.53788,0c-5.51263,1.45166 -11.02526,2.90332 -16.53788,0v3.67509c5.51263,2.90332 11.02526,1.45166 16.53788,0c5.51263,-1.45166 11.02526,-2.90332 16.53788,0zM260.31538,233.99921v-3.67509c-5.51263,-2.90332 -11.02526,-1.45166 -16.53788,0c-5.51263,1.45166 -11.02526,2.90332 -16.53788,0v3.67509c5.51263,2.90332 11.02526,1.45166 16.53788,0c5.51263,-1.45166 11.02526,-2.90332 16.53788,0z" data-paper-data="{&quot;glyphName&quot;:&quot;R&quot;,&quot;glyphIndex&quot;:3,&quot;word&quot;:1,&quot;isPathIcon&quot;:true}"></path></g></g></g></g><g class="watermark-group" style="opacity:0.040000010281801224"><path class="watermark-path" d="M129.52,370.3a11.88,11.88,0,0,1,2.58,5.58,12,12,0,0,1,.11,3,11.81,11.81,0,0,1-.64,2.93,12.34,12.34,0,0,1-1.41,2.72,11.65,11.65,0,0,1-2.13,2.32,12,12,0,0,1-2.64,1.69,13,13,0,0,1-2.91.9,12.47,12.47,0,0,1-3,.12,12.17,12.17,0,0,1-2.93-.64,11.8,11.8,0,0,1-2.72-1.38,12.19,12.19,0,0,1-4-4.79,11.85,11.85,0,0,1-.89-2.92,12.14,12.14,0,0,1-.13-3,11.54,11.54,0,0,1,.64-2.92,11.67,11.67,0,0,1,3.5-5,11.44,11.44,0,0,1,2.67-1.69,11.64,11.64,0,0,1,2.92-.91,10.71,10.71,0,0,1,3-.12,11.68,11.68,0,0,1,5.66,2,11.7,11.7,0,0,1,2.34,2.12m-1.4,8.76a13,13,0,0,1-1.22,2.32,9.68,9.68,0,0,1-1.81,2,7.44,7.44,0,0,1-2.38,1.37,6.17,6.17,0,0,1-5.11-.46,8.73,8.73,0,0,1-3.85-4.58,6.69,6.69,0,0,1-.34-2.66,6.09,6.09,0,0,1,.77-2.47,7.15,7.15,0,0,1,1.75-2.11,9.58,9.58,0,0,1,1.09-.81,8.23,8.23,0,0,1,1.12-.63,8.14,8.14,0,0,1,1.19-.46,12.71,12.71,0,0,1,1.32-.37l2,2.38a12.83,12.83,0,0,0-1.56.17,7.86,7.86,0,0,0-1.23.32,4.5,4.5,0,0,0-1,.49,6.41,6.41,0,0,0-.93.67,4.49,4.49,0,0,0-1.15,1.39,3.87,3.87,0,0,0-.45,1.58,4.12,4.12,0,0,0,.26,1.63,6.11,6.11,0,0,0,2.36,2.82,4.43,4.43,0,0,0,1.57.53,3.91,3.91,0,0,0,1.62-.17,4.71,4.71,0,0,0,1.57-.89,10.5,10.5,0,0,0,.83-.79,5.71,5.71,0,0,0,.65-.93,10.13,10.13,0,0,0,.54-1.14,12.24,12.24,0,0,0,.44-1.49l2,2.33m-14.46,4.55a8.86,8.86,0,0,0,2.78,2.22,9,9,0,0,0,3.29.94,9.15,9.15,0,0,0,3.39-.37,8.68,8.68,0,0,0,3.11-1.69,8.8,8.8,0,0,0,2.22-2.78,9.15,9.15,0,0,0,1-3.29,8.95,8.95,0,0,0-4.83-8.76,9,9,0,0,0-6.73-.57,9,9,0,0,0-5.33,4.47,8.94,8.94,0,0,0-.57,6.71,8.76,8.76,0,0,0,1.7,3.12"></path><path class="watermark-path" d="M147,349c-.48.12-1.09.31-1.82.57a24.37,24.37,0,0,0-2.4,1A28.35,28.35,0,0,0,140,352a20.72,20.72,0,0,0-2.71,1.94c-.7.59-1.28,1.11-1.74,1.57a15.07,15.07,0,0,0-1.1,1.22,4.09,4.09,0,0,0-.59.92,2.32,2.32,0,0,0-.22.64,1.16,1.16,0,0,0,0,.47,1.83,1.83,0,0,0,.18.29,1.15,1.15,0,0,0,1,.37,5.54,5.54,0,0,0,1.51-.38q.87-.35,1.95-.9l2.26-1.18q1.2-.65,2.49-1.29c.87-.44,1.73-.83,2.59-1.17a18.94,18.94,0,0,1,2.6-.81,9.27,9.27,0,0,1,2.46-.29,6.25,6.25,0,0,1,2.24.49,5.12,5.12,0,0,1,1.89,1.47,6.35,6.35,0,0,1,1.41,2.61,6,6,0,0,1,.09,2.6,8.3,8.3,0,0,1-.9,2.52,17.79,17.79,0,0,1-1.62,2.37,23.92,23.92,0,0,1-2,2.15c-.72.67-1.41,1.29-2.09,1.87a33.79,33.79,0,0,1-5.33,3.7,32.29,32.29,0,0,1-4.91,2.28l-3.61-4.3a21.38,21.38,0,0,0,5.39-1.87,27.2,27.2,0,0,0,5.4-3.56,21.59,21.59,0,0,0,2.38-2.27,8.67,8.67,0,0,0,1.18-1.7,2.32,2.32,0,0,0,.27-1.19,1.34,1.34,0,0,0-.28-.74,1.21,1.21,0,0,0-1-.42,4.32,4.32,0,0,0-1.55.34,15.77,15.77,0,0,0-2,.88c-.72.37-1.48.77-2.27,1.21l-2.45,1.3c-.85.45-1.7.85-2.56,1.21a22.37,22.37,0,0,1-2.54.86,10,10,0,0,1-2.43.32,5.76,5.76,0,0,1-2.2-.45,5,5,0,0,1-1.89-1.45,6.12,6.12,0,0,1-1.31-2.41,6,6,0,0,1-.1-2.41,8.28,8.28,0,0,1,.81-2.38,14.06,14.06,0,0,1,1.49-2.24,22.37,22.37,0,0,1,1.85-2.05q1-1,2-1.77c.7-.59,1.44-1.15,2.23-1.7s1.62-1.06,2.44-1.53,1.63-.91,2.43-1.3,1.58-.75,2.3-1L147,349"></path><path class="watermark-path" d="M186.76,337.57l-10.6-12.63,3.92,18.24-4.66,3.91-17.27-7,10.6,12.63-4.86,4.07-15.09-18,6.59-5.54,18.69,7.52-4.15-19.71,6.57-5.52,15.09,18-4.83,4.05"></path><path class="watermark-path" d="M208.84,313.24l-10,8.42,1.16,4.82L194.56,331l-5.68-25.89,5.42-4.55,24.51,10.09-5.42,4.55-4.55-2m-11.23,3.45,6.57-5.52-8.83-3.87,2.26,9.39"></path><path class="watermark-path" d="M227.49,281.38c-.48.12-1.09.31-1.82.57a24.37,24.37,0,0,0-2.4,1,26.11,26.11,0,0,0-2.7,1.47,20.72,20.72,0,0,0-2.71,1.94c-.7.59-1.28,1.11-1.74,1.57a13.39,13.39,0,0,0-1.1,1.22,4.29,4.29,0,0,0-.59.91,2.48,2.48,0,0,0-.22.65,1.16,1.16,0,0,0,0,.47,1.83,1.83,0,0,0,.18.29,1.15,1.15,0,0,0,1,.37,5.54,5.54,0,0,0,1.51-.38q.87-.34,2-.9l2.26-1.18q1.2-.64,2.49-1.29c.87-.44,1.73-.83,2.59-1.17a18.94,18.94,0,0,1,2.6-.81,9.27,9.27,0,0,1,2.46-.29,6.08,6.08,0,0,1,2.24.49,5.09,5.09,0,0,1,1.89,1.46,6.47,6.47,0,0,1,1.41,2.61,6.07,6.07,0,0,1,.09,2.61,8.3,8.3,0,0,1-.9,2.52,16.32,16.32,0,0,1-1.63,2.36,21.41,21.41,0,0,1-2,2.16c-.72.67-1.41,1.29-2.1,1.86a33.36,33.36,0,0,1-5.32,3.71,31.92,31.92,0,0,1-4.92,2.28l-3.6-4.3a21.38,21.38,0,0,0,5.39-1.87,27.2,27.2,0,0,0,5.4-3.56,21.59,21.59,0,0,0,2.38-2.27,8.67,8.67,0,0,0,1.18-1.7A2.32,2.32,0,0,0,231,293a1.34,1.34,0,0,0-.28-.74,1.21,1.21,0,0,0-1-.42,4.32,4.32,0,0,0-1.55.34,16.54,16.54,0,0,0-2,.88c-.71.37-1.47.77-2.26,1.21l-2.46,1.3c-.84.44-1.7.85-2.55,1.21a24.53,24.53,0,0,1-2.54.86A10,10,0,0,1,214,298a5.76,5.76,0,0,1-2.2-.45,5,5,0,0,1-1.89-1.45,6.12,6.12,0,0,1-1.31-2.41,5.78,5.78,0,0,1-.1-2.41,8,8,0,0,1,.81-2.38,14.61,14.61,0,0,1,1.49-2.25,22.26,22.26,0,0,1,1.85-2q1-1,2-1.77c.7-.59,1.44-1.15,2.23-1.7s1.62-1.06,2.44-1.53,1.63-.91,2.43-1.31,1.58-.74,2.3-1l3.5,4.16"></path><path class="watermark-path" d="M261.64,274.74l-6.29-7.5L243,277.61l6.3,7.5-4.86,4.07-15.09-18,4.85-4.08,5.49,6.55L252,263.3l-5.49-6.55,4.86-4.07,15.09,18-4.86,4.08"></path><path class="watermark-path" d="M272.18,265.9l-15.09-18,4.86-4.08,15.09,18-4.86,4.08"></path><path class="watermark-path" d="M299.65,242.85l-22.51-2.18L287.51,253l-4.85,4.08-15.1-18,5.28-4.43,22.56,2.22L285,224.5l4.83-4.06,15.09,18-5.26,4.42"></path><path class="watermark-path" d="M306.68,205.52a31.88,31.88,0,0,1,5.29-3.66,34.48,34.48,0,0,1,5.14-2.35l3.69,4.39a20.77,20.77,0,0,0-2.37.61,20.47,20.47,0,0,0-2.61,1,25.12,25.12,0,0,0-2.76,1.49,23.9,23.9,0,0,0-2.8,2,20.42,20.42,0,0,0-2.8,2.77,12.77,12.77,0,0,0-1.64,2.52,7,7,0,0,0-.68,2.24,6,6,0,0,0,.66,3.64,8.16,8.16,0,0,0,.94,1.38,9.12,9.12,0,0,0,1.08,1.07,6.39,6.39,0,0,0,1.47.91,6.73,6.73,0,0,0,1.88.48,6.54,6.54,0,0,0,2.28-.18,11.67,11.67,0,0,0,2.74-1.07,19.38,19.38,0,0,0,3.18-2.22c.57-.48,1.06-.92,1.46-1.31a14.57,14.57,0,0,0,1-1.13,11.46,11.46,0,0,0,.81-1.05l.74-1.09-1.82-2.17-5.45,4.57-3.31-3.94,10.31-8.65,7.71,9.19a29,29,0,0,1-1.67,2.43q-1,1.26-2.1,2.52c-.74.84-1.5,1.65-2.3,2.44s-1.58,1.5-2.33,2.14a31,31,0,0,1-3.59,2.61,22.55,22.55,0,0,1-3.64,1.83,15.64,15.64,0,0,1-3.63.89,10.72,10.72,0,0,1-3.49-.15,10.45,10.45,0,0,1-3.28-1.33,12.54,12.54,0,0,1-3-2.67,12,12,0,0,1-2.08-3.44,10.45,10.45,0,0,1-.71-3.5,11.14,11.14,0,0,1,.51-3.51,15.72,15.72,0,0,1,1.56-3.43,21.62,21.62,0,0,1,2.42-3.28,30.3,30.3,0,0,1,3.15-3"></path><path class="watermark-path" d="M336.91,211.59l-15.1-18,4.86-4.08,11.79,14,13.13-11,3.31,3.94-18,15.1"></path><path class="watermark-path" d="M374.54,164.71a12.28,12.28,0,0,1,2.59,4.81,10.44,10.44,0,0,1,0,5,14.62,14.62,0,0,1-2.33,5,25.55,25.55,0,0,1-4.56,4.85,26.07,26.07,0,0,1-5.6,3.67,14.79,14.79,0,0,1-5.38,1.43,10.43,10.43,0,0,1-4.94-.89,13.24,13.24,0,0,1-6.87-8.18,10.48,10.48,0,0,1,0-5,14.51,14.51,0,0,1,2.36-5,25.23,25.23,0,0,1,4.57-4.89,25,25,0,0,1,5.59-3.64,14.45,14.45,0,0,1,5.35-1.43,10.31,10.31,0,0,1,4.93.92,12.22,12.22,0,0,1,4.28,3.38m-4.91,4.11a8.36,8.36,0,0,0-2-1.72,5.5,5.5,0,0,0-2.65-.85,7.72,7.72,0,0,0-3.32.57,14.49,14.49,0,0,0-4,2.52,16.72,16.72,0,0,0-2.38,2.4,10.15,10.15,0,0,0-1.39,2.24,6.71,6.71,0,0,0-.56,2.1,5.69,5.69,0,0,0,.1,1.9,6.21,6.21,0,0,0,.61,1.69,9.85,9.85,0,0,0,1,1.44,10.48,10.48,0,0,0,1.26,1.23,6.67,6.67,0,0,0,1.57.92,6.1,6.1,0,0,0,1.85.41,6.8,6.8,0,0,0,2.15-.2,11.06,11.06,0,0,0,2.45-1,17.67,17.67,0,0,0,2.77-1.94,14.39,14.39,0,0,0,3.18-3.52,7.74,7.74,0,0,0,1.14-3.17,5.54,5.54,0,0,0-.37-2.74,8.52,8.52,0,0,0-1.36-2.3"></path><path class="watermark-path" d="M382.66,141.76A32.3,32.3,0,0,1,388,138.1a34.12,34.12,0,0,1,5.15-2.35l3.69,4.4a19.62,19.62,0,0,0-2.37.6,22.08,22.08,0,0,0-2.61,1,26,26,0,0,0-2.77,1.49,23.9,23.9,0,0,0-2.8,2,21,21,0,0,0-2.8,2.78,13.19,13.19,0,0,0-1.64,2.51,7.29,7.29,0,0,0-.68,2.24,6.36,6.36,0,0,0,.06,2,5.8,5.8,0,0,0,.61,1.68,8.12,8.12,0,0,0,.93,1.38,9.16,9.16,0,0,0,1.08,1.08,6.56,6.56,0,0,0,1.48.9,6,6,0,0,0,1.87.48,6.76,6.76,0,0,0,2.28-.17,12,12,0,0,0,2.74-1.08,18.57,18.57,0,0,0,3.18-2.22c.58-.48,1.06-.92,1.46-1.31s.75-.77,1.05-1.12.57-.72.81-1.06l.73-1.09-1.82-2.17-5.45,4.57-3.3-3.94,10.3-8.65,7.71,9.19a29,29,0,0,1-1.67,2.43q-1,1.26-2.1,2.52c-.73.84-1.5,1.66-2.3,2.44s-1.57,1.5-2.33,2.14a31,31,0,0,1-3.59,2.61,22.15,22.15,0,0,1-3.64,1.83,15.56,15.56,0,0,1-3.62.89,11,11,0,0,1-3.49-.14,10.84,10.84,0,0,1-3.28-1.33,12.82,12.82,0,0,1-3-2.68,12.12,12.12,0,0,1-2.08-3.43A10.71,10.71,0,0,1,375,155a11.18,11.18,0,0,1,.51-3.51,15.51,15.51,0,0,1,1.57-3.43,21.44,21.44,0,0,1,2.42-3.28,30.19,30.19,0,0,1,3.14-3"></path><path class="watermark-path" d="M428.63,119.31a12.26,12.26,0,0,1,2.59,4.82,10.44,10.44,0,0,1,0,5,14.53,14.53,0,0,1-2.34,5,25.29,25.29,0,0,1-4.56,4.86,26,26,0,0,1-5.59,3.67,14.84,14.84,0,0,1-5.38,1.43,10.61,10.61,0,0,1-4.95-.89,12.15,12.15,0,0,1-4.3-3.37,12,12,0,0,1-2.56-4.81,10.48,10.48,0,0,1,0-5,14.39,14.39,0,0,1,2.35-5,27.89,27.89,0,0,1,10.16-8.53,14.49,14.49,0,0,1,5.36-1.43,10.27,10.27,0,0,1,4.92.92,12.21,12.21,0,0,1,4.28,3.37m-4.91,4.12a8.17,8.17,0,0,0-2-1.72,5.58,5.58,0,0,0-2.65-.86,7.86,7.86,0,0,0-3.31.58,14.49,14.49,0,0,0-4,2.52,16.21,16.21,0,0,0-2.38,2.4,9.85,9.85,0,0,0-1.4,2.24,7,7,0,0,0-.56,2.1,6,6,0,0,0,.1,1.9,6.23,6.23,0,0,0,.62,1.69,8.49,8.49,0,0,0,1,1.44,9.18,9.18,0,0,0,1.26,1.23,6.67,6.67,0,0,0,1.57.92,6,6,0,0,0,1.84.41,6.86,6.86,0,0,0,2.16-.2,11.26,11.26,0,0,0,2.45-1,17.62,17.62,0,0,0,2.76-1.94,14.67,14.67,0,0,0,3.19-3.52,7.71,7.71,0,0,0,1.13-3.17,5.53,5.53,0,0,0-.36-2.74,8.55,8.55,0,0,0-1.37-2.3"></path></g></svg>
 <!--h1>SMART<b>CELL</b></h1-->
</br>
<!--p class="text-medium-emphasis" style="color:white !important;">Iniciar Sesion al Sistema</p-->
<form method="post" action="./?action=processlogin">
<div class="input-group mb-3"><span class="input-group-text">
<svg class="icon">
<use xlink:href="./vendors/@coreui/icons/svg/free.svg#cil-user"></use>
</svg></span>
<input class="form-control" type="text" name="username" placeholder="Usuario">
</div>
<div class="input-group mb-4"><span class="input-group-text">
<svg class="icon">
<use xlink:href="./vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
</svg></span>
<input class="form-control" name="password" type="password" placeholder="Contraseña">
</div>
<div class="row mt-4 pt-3">
<div class="col text-center">
<button class="btn btn-primary px-4 w-75 btn-sub" type="submit" >Iniciar Sesion</button>
</div>
<!--
<div class="col-6 text-end">
<button class="btn btn-link px-0" type="button">Forgot password?</button>
</div>
-->
</div>
</form>
<br><br><br>

</div>
</div>

</div>
</div>
</div>
</div>
</div>
<?php
else:
header('location: ./index.php?view=home');
endif; ?>
    <!-- CoreUI and necessary plugins-->
    <script src="./vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
    <script src="./vendors/simplebar/js/simplebar.min.js"></script>
    <!-- Plugins and scripts required by this view-->
    <script src="./vendors/@coreui/utils/js/coreui-utils.js"></script>
    <script>
    </script>

  </body>
</html>