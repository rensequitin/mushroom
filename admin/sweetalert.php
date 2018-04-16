<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge;" />
  <title>SweetAlert2 - a beautiful, responsive, customizable and accessible (WAI-ARIA) replacement for JavaScript's popup boxes</title>
  
  <link rel="stylesheet" href="./assets/example.css">
  <link rel="stylesheet" href="./assets/bootstrap4-buttons.css">

  <script src="js/jquery.js"></script>



  <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support -->
  

  <!-- This is what you need -->
  <script src="./dist/sweetalert2.all.min.js"></script>
  <!--.......................-->
</head>

<body>
  <header>
    <img src="./assets/swal2-logo.png" class="logo" width="498" alt="SweetAlert2 logo">
    <h1>A beautiful, responsive, customizable, accessible (WAI-ARIA) replacement for JavaScript's popup boxes</h2>
    <h2>Zero dependencies</h2>
    <div class="carbonads-wrapper">
      <script src="//cdn.carbonads.com/carbon.js?zoneid=1673&serve=C6AILKT&placement=limontegithubiosweetalert2" id="_carbonads_js" async></script>
    </div>
    <div class="stats mobile-hidden">
      Current version: <a href="https://github.com/limonte/sweetalert2/releases" id="current-version" aria-label="Current version "></a> ●
      Latest update: <a href="https://github.com/limonte/sweetalert2/commits/master" id="latest-update" aria-label="Latest update "></a> ●
      Downloads last month: <a href="https://npm-stat.com/charts.html?package=sweetalert2" id="downloads-last-month" aria-label="Downloads last month "></a>
    </div>
    <a class="top-right-button download">Download</a>
    <a href="https://cdnjs.com/libraries/limonte-sweetalert2" tabindex="-1" class="top-right-button cdn" target="_blank" rel="noopener">CDN</a>
    <div class="top-right-button donate">
      <img src="./assets/paypal.png" width="32" height="32" alt="">
      <span>Donate</span>
    </div>
  </header>

  <div class="showcase normal">
    <h4>Normal alert</h4>
    <button>Show normal alert</button>
    <pre><span class="func">alert</span>(<span class="str">'You clicked the button!'</span>)</pre>
    <div class="vs-icon"></div>
  </div>

  <div class="showcase sweet">
    <img src="./assets/swal2-logo.png" height="30" alt="SweetAlert2">
    <button aria-label="Show SweetAlert2 success message">Show success message</button>
    <pre>
swal(
  <span class="str">'Good job!'</span>,
  <span class="str">'You clicked the button!'</span>,
  <span class="str">'success'</span>
)</pre>
  </div>

  <p>Pretty cool huh? SweetAlert2 automatically centers itself on the page and looks great no matter if you're using a desktop computer, mobile or tablet. It's even highly customizeable, as you can see below!</p>


  <!-- Examples -->

<script>
  /* global $, swal, FileReader */
  $('.download').on('click', () => {
    $('html, body').animate({scrollTop: $('.download-section').offset().top}, 1000)
  })

  $('.donate').on('click', () => {
    $('html, body').animate({scrollTop: $('.donations-section').offset().top}, 1000)
  })

  $('.showcase.normal button').on('click', () => {
    window.alert('You clicked the button!')
  })

  $('.showcase.sweet button').on('click', () => {
    swal('Good job!', 'You clicked the button!', 'success')
  })

  
</script>

</body>
</html>
