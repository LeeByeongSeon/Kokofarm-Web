<?
  $mnuName = array(
    //장치 현황
    array("01_device_mnt", "0101.php", "장치 현황", "요약 현황", "Y", "fa fa-lg fa-fw fa-home"),
    array("01_device_mnt", "0102.php", "장치 현황", "동별 세부 현황", "", ""),
    array("01_device_mnt", "0103.php", "장치 현황", "IP 카메라 현황", "", ""),
    
    //농장 현황
    array("02_farm_mnt", "0201.php", "농장 현황", "입출하 관리", "Y", "fa fa-lg fa-fw fa-bar-chart-o"),
    array("02_farm_mnt", "0202.php", "농장 현황", "전국 농장 현황", "", ""),
    array("02_farm_mnt", "0203.php", "농장 현황", "동별 세부 현황", "", ""),
    array("02_farm_mnt", "0204.php", "농장 현황", "출하이력", "", ""),
    array("02_farm_mnt", "0205.php", "농장 현황", "재산출 요청 관리", "", ""),
    array("02_farm_mnt", "0206.php", "농장 현황", "결함 및 A/S 관리", "", ""),
    
    //계정 관리
    array("03_account_mgr", "0301.php", "계정 관리", "농장 계정 관리", "Y", "fa fa-lg fa-fw fa-group"),
    array("03_account_mgr", "0302.php", "계정 관리", "농장별 동 관리", "", ""),
    array("03_account_mgr", "0303.php", "계정 관리", "관리자 계정 관리", "", ""),
    
    //장치 관리
    array("04_device_mgr", "0401.php", "장치 관리", "IoT 저울 관리", "Y", "fa fa-lg fa-fw fa-video-camera"),
    array("04_device_mgr", "0402.php", "장치 관리", "IP 카메라 관리", "", ""),
    array("04_device_mgr", "0403.php", "장치 관리", "PLC 관리", "", ""),
    array("04_device_mgr", "0404.php", "장치 관리", "급이/급수/외기 관리", "", ""),

    //옵션 관리
    array("05_option_mgr", "0501.php", "옵션 관리", "상세 옵션 관리", "Y", "fa fa-lg fa-fw fa-cog"),
    array("05_option_mgr", "0502.php", "옵션 관리", "PLC Unit ID 관리", "", ""),
  );
  
    //현재 URL 확인 및 메뉴출력
    $currURL   = $_SERVER["PHP_SELF"];        $arrURL    = explode("/",$currURL);
    $depth1URL = $arrURL[sizeof($arrURL)-2];  $depth2URL = $arrURL[sizeof($arrURL)-1];

    $topMenuHTML = "";
    foreach($mnuName as $value)
    {
      switch ($value[4])
      {
        case 'Y':
          if($depth1URL == $value[0])
          {
            $topMenuHTML .= "<li class='active'>";
            $topMenuHTML .= " <a class='has-arrow' href='#'><span class='".$value[5]."'></span><span class='menu-item-parent'>".$value[2]."</span></a>";
            $topMenuHTML .= "   <ul aria-expanded='true' class='sa-sub-nav collapse'>";
          }else
          {
            $topMenuHTML .= "<li class=''>";
            $topMenuHTML .= " <a class='has-arrow' href='#'><span class='".$value[5]."'></span><span class='menu-item-parent'>".$value[2]."</span></a>";
            $topMenuHTML .= "   <ul aria-expanded='true' class='sa-sub-nav collapse'>";
          }
          //서브메뉴 for문
          for($i=0; $i<=count($mnuName)-1; $i++)
          {
            if($mnuName[$i][0]==$value[0])
            {
              if($depth1URL==$mnuName[$i][0] && $depth2URL==$mnuName[$i][1])
              {
                $topMenuHTML .= "<li class='active'><a href='javascript:void(0)' onClick=\" location.href='../" . $mnuName[$i][0] . "/" . $mnuName[$i][1] . "' \">". $mnuName[$i][3] ."</a></li>";
              }else
              {
                $topMenuHTML .= "<li class=''><a href='javascript:void(0)' onClick=\" location.href='../" . $mnuName[$i][0] . "/" . $mnuName[$i][1] . "' \">" . $mnuName[$i][3] . "</a></li>";
              }
            }
          }
          $topMenuHTML .="   </ul>";
          $topMenuHTML .="</li>";
          break;

        case 'N':
          if($depth1URL == $value[0])
          {
            $topMenuHTML .= "<li class='active'>";
            $topMenuHTML .= " <a href='javascript:void(0)' onclick=\" location.href='../" . $value[0] . "/" . $value[1] . "' \"><span class='".$value[5]."'></span><span class='menu-item-parent'>".$value[3]."</span></a>";
            $topMenuHTML .= "</li>";
          }else
          {
            $topMenuHTML .= "<li class=''>";
            $topMenuHTML .= " <a href='javascript:void(0)' onclick=\" location.href='../" . $value[0] . "/" . $value[1] . "' \"><span class='".$value[5]."'></span><span class='menu-item-parent'>".$value[3]."</span></a>";
            $topMenuHTML .= "</li>";
          }
          break;
      }
    }

    //header 제목
    $titleHTML = "";
    foreach ($mnuName as $value)
    {
      if($depth1URL == $value[0] && $depth2URL == $value[1])
      {
        $titleHTML .= "<h4 class='page-header'><i class='fa-fw fa fa-th-list'></i> ".$value[2]."<span> <i class='fa-fw fa fa-angle-right'></i> <b>".$value[3]."</b></span></h4>";
      }
    }
?>

<!DOCTYPE html>

<html lang="en" class="smart-style-0">
<head>
  <title>KOKOFARM RENEWAL</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,500,700">
  
   <!-- FAVICONS -->
  <link rel="shortcut icon" href="../images/icon.png" type="image/x-icon">
  <link rel="icon" href="../images/icon.png" type="image/x-icon">
  
  <!-- jQuery Grid -->
  <!--<script src="../library/jqgrid/jquery.jqGrid.min.js" type="text/javascript"></script>     JQGrid-->
  <!--<script src="../library/jqgrid/i18n/grid.locale-kr.js" type="text/javascript"></script>  JQGrid:Language-->
  <link href="../library/jqgrid/ui.jqgrid-bootstrap.css" rel="stylesheet" type="text/css">  <!--JQGrid:CSS--->

  <!--amChart-->
  <script src="../library/amchart/amcharts.js" type="text/javascript"></script>
  <script src="../library/amchart/serial.js" type="text/javascript"></script>
  <script src="../library/amchart/lang/ko.js" type="text/javascript"></script>

  <!-- myDefined JS
  <script src="../library/my_define/my_define.js"></script> -->

  <link rel="stylesheet" media="screen, print" href="../assets/vendors/vendors.bundle.css">
  <link rel="stylesheet" media="screen, print" href="../assets/app/app.bundle.css">
  <link rel="stylesheet" type="text/css" href="../assets/pages/homepage.css">
  <link rel="stylesheet" type="text/css" href="../assets/pages/forms.css">
  <link rel="stylesheet" type="text/css" href="../assets/pages/buttons.css">


</head>
<body class="   smart-style-0 sa-menu-on-top sa-fixed-header sa-fixed-navigation">
  
  <!-- BEGIN .sa-wrapper -->
  <div class="sa-wrapper">
        
        <header class="sa-page-header">
          <div class="sa-header-container h-100">
            <div class="d-table d-table-fixed h-100 w-100">

              <div class="sa-logo-space d-table-cell h-100">
                <div class="flex-row d-flex align-items-center h-100">
                  <a class="sa-logo-link" href="../01_summary/0101.php" title="KOKOFARM"><img alt="KOKOFARM" src="../images/logo.png" class="sa-logo"></a>
                </div>  
              </div>

              <div class="d-table-cell h-100 w-100 align-middle">
                <div class="sa-header-menu">
                  <div class="d-flex align-items-center w-100">
                    <div class="ml-auto sa-header-right-area">

                      <div class="form-inline">
                          <a class="btn btn-dark" href="../index.php" title="logout" role="button"><i class="fa fa-sign-out fa-lg"> Logout</i></a>
                      </div>

                    </div>
                  </div>          
                </div>
              </div>

            </div>
          </div>
        </header> <!-- END .sa-page-header -->

    <div class="sa-page-body">
      
      <!-- 메뉴바 -->
      <div class="sa-aside-left">
          <div class="sa-left-menu-outer">
            <ul class="metismenu sa-left-menu" id="menu1">
              <?=$topMenuHTML?>
            </ul>
          </div>
      </div>

      <!-- BEGIN .sa-content-wrapper -->
      <div class="sa-content-wrapper">
        
    <div class="sa-content">

      <div class="d-flex w-100 home-header">

        <!--화면 Title-->
        <div>
          <?=$titleHTML?>       
        </div>

      </div><!--END .d-flex w-100 home-header-->

      <div class="d-flex w-100">

        <section id="widget-grid" class="   w-100 ">

        

        <!--농장 트리뷰-->
        
      <div class="col-xl-2 no-padding" style="position:fixed">
          <div id="treeView" class="col-xl-12 float-left no-padding">
            
            <div class="jarviswidget jarviswidget-color-darken no-padding" id="wid-id-13" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false">
              <header>
                <div class="widget-header">
                  <span class="widget-icon"> <i class="fa fa-list"></i> </span>
                  <h2>농가 목록 </h2>
                </div>		
              </header>
      
                <div class="widget-body">

                  <!--농장 트리뷰 검색필드-->
                  <div class="widget-body-toolbar bg-white" style="margin-bottom:10px; padding-top:20px; padding-left:20px;">
                    <form class="form-inline" role="form" style="padding-bottom:10px;">
                      <div class="input-group">
                      <input type="text" class="form-control" placeholder="농장 이름" max-length="20">&nbsp;&nbsp;
                      <button type="button" class="btn btn-warning">검색</button>
                      </div>
                    </form>
                  </div>	

									
									<div class="custom-scroll table-responsive" style="height:600px; overflow-y: scroll;">

                  <!--농장 트리뷰 body 부분-->
                  <div class="tree smart-form" style="margin-left:20px;">
                    <ul>
                      <li>
                        <span><i class="fa fa-lg fa-folder-open"></i> 농장 이름</span>
                        <ul>
                          <li>
                            <span>01 동</span>
                          </li>
                          <li>
                            <span>02 동</span>
                          </li>
                          <li>
                            <span>03 동</span>
                          </li>
                        </ul>
                      </li>
                      <li>
                        <span><i class="fa fa-lg fa-folder-open"></i> 농장 이름</span>
                        <ul>
                          <li>
                            <span><i class="icon-leaf"></i> 동</span>
                          </li>
                        </ul>
                      </li>
                      <li>
                        <span><i class="fa fa-lg fa-folder-open"></i> 농장 이름</span>
                        <ul>
                          <li>
                            <span><i class="icon-leaf"></i> 동</span>
                          </li>
                        </ul>
                      </li>
                      <li>
                        <span><i class="fa fa-lg fa-folder-open"></i> 농장 이름</span>
                        <ul>
                          <li>
                            <span><i class="icon-leaf"></i> 동</span>
                          </li>
                        </ul>
                      </li>
                      <li>
                        <span><i class="fa fa-lg fa-folder-open"></i> 농장 이름</span>
                        <ul>
                          <li>
                            <span><i class="icon-leaf"></i> 동</span>
                          </li>
                        </ul>
                      </li>
                      <li>
                        <span><i class="fa fa-lg fa-folder-open"></i> 농장 이름</span>
                        <ul>
                          <li>
                            <span><i class="icon-leaf"></i> 동</span>
                          </li>
                        </ul>
                      </li>
                      <li>
                        <span><i class="fa fa-lg fa-folder-open"></i> 농장 이름</span>
                        <ul>
                          <li>
                            <span><i class="icon-leaf"></i> 동</span>
                          </li>
                        </ul>
                      </li>
                      <li>
                        <span><i class="fa fa-lg fa-folder-open"></i> 농장 이름</span>
                        <ul>
                          <li>
                            <span><i class="icon-leaf"></i> 동</span>
                          </li>
                        </ul>
                      </li>
                      <li>
                        <span><i class="fa fa-lg fa-folder-open"></i> 농장 이름</span>
                        <ul>
                          <li>
                            <span><i class="icon-leaf"></i> 동</span>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </div>  <!--농장 트리뷰 body 부분-->

                  </div>

                </div>
      
            </div>

          </div>  <!--농장 트리뷰 end-->
       </div>