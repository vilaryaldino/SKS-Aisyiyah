<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
  <title>SKS-AISYIYAH 6 Candi</title>
  <!-- [Meta] -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
  <meta name="keywords" content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
  <meta name="author" content="CodedThemes">

  <!-- [Favicon] icon -->
  <link rel="icon" href="<?= base_url('images/logo_new.png') ?>" type="image/x-icon"> <!-- [Google Font] Family -->
  <!-- [Google Font] Family -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- [Tabler Icons] https://tablericons.com -->
  <link rel="stylesheet" href="/templateAdmin/dist/assets/fonts/tabler-icons.min.css">
  <!-- [Feather Icons] https://feathericons.com -->
  <link rel="stylesheet" href="/templateAdmin/dist/assets/fonts/feather.css">
  <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
  <link rel="stylesheet" href="/templateAdmin/dist/assets/fonts/fontawesome.css">
  <!-- [Material Icons] https://fonts.google.com/icons -->
  <link rel="stylesheet" href="/templateAdmin/dist/assets/fonts/material.css">
  <!-- [Template CSS Files] -->
  <link rel="stylesheet" href="/templateAdmin/dist/assets/css/style.css" id="main-style-link">
  <link rel="stylesheet" href="/templateAdmin/dist/assets/css/style-preset.css">

  <style>
    :root {
      --bs-font-sans-serif: 'Inter', sans-serif;
      --primary-color: #4361ee;
      --secondary-color: #3f37c9;
      --success-color: #4cc9f0;
      --info-color: #4895ef;
      --warning-color: #f72585;
      --danger-color: #e63946;
      --light-bg: #f8f9fa;
      --dark-text: #212529;
      --card-shadow: 0 10px 20px rgba(0,0,0,0.05);
      --card-radius: 12px;
    }

    body {
      font-family: var(--bs-font-sans-serif) !important;
      background-color: #f3f4f6;
      color: var(--dark-text);
    }

    /* Card Styling */
    .card {
      border: none;
      border-radius: var(--card-radius);
      box-shadow: var(--card-shadow);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      background: #fff;
      margin-bottom: 24px;
    }
    
    .card:hover {
      transform: translateY(-2px);
      box-shadow: 0 15px 30px rgba(0,0,0,0.08);
    }

    .card-header {
      background-color: transparent;
      border-bottom: 1px solid rgba(0,0,0,0.05);
      padding: 20px 24px;
    }

    .card-header h5 {
      font-weight: 600;
      margin-bottom: 0;
      color: var(--dark-text);
    }
    
    /* Table Styling */
    .table thead th {
      background-color: #f8f9fa;
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.85rem;
      letter-spacing: 0.5px;
      color: #6c757d;
      border-bottom: 2px solid #e9ecef;
    }
    
    .table tbody td {
      vertical-align: middle;
      color: #495057;
    }

    /* Sidebar Tweaks (Clean & Functional) */
    .pc-sidebar .pc-item .pc-link {
        font-size: 14px;
        padding: 10px 20px;
        margin: 2px 0;
        border-radius: 0;
        transition: all 0.2s ease-in-out;
    }
    
    .pc-sidebar .pc-item.active .pc-link,
    .pc-sidebar .pc-item:hover .pc-link {
        background: rgba(67, 97, 238, 0.08); /* Very light highlight */
        color: var(--primary-color);
        border-right: 3px solid var(--primary-color); /* Simple active indicator */
    }

    .pc-sidebar .pc-caption {
        margin-top: 5px;   /* Reduced from 15px */
        margin-bottom: 2px; /* Reduced from 5px */
        color: #888;
        padding-left: 20px; /* Aligned with items */
    }
    
    /* Fix: Ensure sidebar content hides correctly when collapsed */
    .pc-sidebar-hide .pc-mtext {
        display: none;
    }

    /* Navbar Tweaks (Subtle) */
    .pc-header {
        box-shadow: 0 2px 10px rgba(0,0,0,0.05); /* Lighter shadow */
    }

    html {
      font-size: 14px;
    }

    @media (max-width: 768px) {
      html {
        font-size: 13px;
      }
    }
  </style>

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
  <!-- [ Pre-loader ] start -->
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>
  <!-- [ Pre-loader ] End -->

  <!-- [ Sidebar Menu ] start -->
  <?= $this->include('partisi/sidebar') ?>
  <!-- [ Sidebar Menu ] end -->

  <!-- [ Header Topbar ] start -->
  <?= $this->include('partisi/navbar') ?>
  <!-- [ Header ] end -->



  <!-- [ Main Content ] start -->
  <div class="pc-container">
    <div class="pc-content">
      <?= $this->renderSection('content'); ?>
    </div>
  </div>
  <!-- [ Main Content ] end -->

  <?= $this->include('partisi/footer') ?>

  <!-- [Page Specific JS] start -->
  <script src="/templateAdmin/dist/assets/js/plugins/apexcharts.min.js"></script>
  <script src="/templateAdmin/dist/assets/js/pages/dashboard-default.js"></script>
  <!-- [Page Specific JS] end -->
  <!-- Required Js -->
  <script src="/templateAdmin/dist/assets/js/plugins/popper.min.js"></script>
  <script src="/templateAdmin/dist/assets/js/plugins/simplebar.min.js"></script>
  <script src="/templateAdmin/dist/assets/js/plugins/bootstrap.min.js"></script>
  <script src="/templateAdmin/dist/assets/js/fonts/custom-font.js"></script>
  <script src="/templateAdmin/dist/assets/js/pcoded.js"></script>
  <script src="/templateAdmin/dist/assets/js/plugins/feather.min.js"></script>





  <script>
    layout_change('light');
  </script>




  <script>
    change_box_container('false');
  </script>



  <script>
    layout_rtl_change('false');
  </script>


  <script>
    preset_change("preset-1");
  </script>


  <script>
    font_change("Public-Sans");
  </script>



</body>
<!-- [Body] end -->

</html>