<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Perhatian</title>
</head>

<style type="text/css">
  body {
    text-align: center;
    background-color: #efefef;
    color: #333;
  }
  table {
    border-collapse: collapse;
  }
  .wrapper {
      display: inline-block;
      text-align: left;
      width: auto;
      background-color: #fff;
      padding: 50px;
      margin-top: 40px;
  }

  .title {
    font-weight: bold;
    font-size: 2.5em;
    margin-bottom: 30px;
  }
  .detail-info, .list-info {
    margin-bottom: 30px;
  }
  .detail-info tr > td, .list-info tr > td, .list-info tr > th {
      border: 1px solid #e1e1e1 !important;
      padding: 10px;
  }

  .button-default {
    background-color: #42A5F5;
      border: 1px solid #e1e1e1;
      color: #fff;
      padding: 10px;
      text-decoration: none;
  }
</style>
<body style="text-align: center;background-color: #efefef;color: #333;">


      
<table class="wrapper" style="border-collapse: collapse;display: inline-block;text-align: left;width: auto;background-color: #fff;padding: 50px;margin: 40px;">
  <tr>
    <td colspan="2 ">
      <p class="title" style="font-weight: bold;font-size: 40px;margin-bottom: 30px;"> <center class="title">PT AISIN INDONESIA AUTOMOTIVE</center></p>
       <center> <span style="color: yellow; font-size: 40px"> REAL TIME ALERT LINE STATUS </span> </center>
    </td>
  </tr>
  <tr>
    <td style="font-size: 20px">
      TANGGAL   <br>
      STATUS    <br>
      LINE      <br>
    </td>
    <td style="font-size: 20px">
      :   {{$tanggal}}<br>
      :   Terjadi {{$status}} Selama lebih dari {{$time}} Menit<br>
      :   {{$line}}<br>
    </td>
  </tr>
  <tr>
    <td>
      <a href="{{url('/direct/line')}}"> Lihat Dashboard <a/>
    </td>
  </tr>

</table>

</body>
</html>