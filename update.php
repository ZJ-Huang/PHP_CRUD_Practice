<?php
include("connMysqlObj.php");
//用欄位 action 值是否為 update，判斷現在是否是更新的動作
if (isset($_POST["action"])&&($_POST["action"]=="update")) {
    $sql_query = "UPDATE students SET cName=? ,cSex=? ,cBirthday=? ,cEmail=? ,cPhone=? ,cAddr=? WHERE cID=?";
    //預備語法
    $stmt = $db_link -> prepare($sql_query);
    $stmt -> bind_param("ssssssi", $_POST["cName"], $_POST["cSex"], $_POST["cBirthday"], $_POST["cEmail"], $_POST["cPhone"], $_POST["cAddr"], $_POST["cID"]);
    $stmt -> execute();
    $stmt -> close();
    $db_link -> close();
    //重新導向回到主畫面
    header("Location: http://localhost/crud/data.php");
}
//取出要修改的資料設定為欄位預設值
$sql_query = "SELECT cID ,cName ,cSex ,cBirthday ,cEmail ,cPhone ,cAddr FROM students WHERE cID=?";
$stmt = $db_link -> prepare($sql_query);
$stmt -> bind_param("i", $_GET["id"]);
$stmt -> execute();
$stmt -> bind_result($cid, $cname, $csex, $cbirthday, $cemail, $cphone, $caddr);
$stmt -> fetch();
?>
<html>

<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>學生資料管理系統</title>
  <style>
    h1,
    p {
      text-align: center;
    }

    table {
      border: 1px solid #000;
      font-family: 微軟正黑體;
      font-size: 16px;
      width: 100%;
      border: 1px solid #000;
      text-align: center;
      border-collapse: collapse;
    }

    th {
      background-color: #009FCC;
      padding: 10px;
      border: 1px solid #000;
      color: #fff;
    }

    td {
      border: 1px solid #000;
      padding: 5px;
    }
  </style>
</head>

<body>
  <h1>學生資料管理系統 - 修改資料</h1>
  <p><a href="data.php">回主畫面</a></p>
  <!-- 用 action="" 代表送回本頁 -->
  <form action="" method="post" name="formFix" id="formFix">
    <table>
      <tr>
        <th>欄位</th>
        <th>資料</th>
      </tr>
      <tr>
        <td>姓名</td>
        <td>
          <input type="text" name="cName" id="cName"
            value="<?php echo $cname; ?>">
        </td>
      </tr>
      <tr>
        <td>性別</td>
        <td>
          <input type="radio" name="cSex" id="radio" value="M" <?php if ($csex == "M") {
    echo "checked";
} ?>>男
          <input type="radio" name="cSex" id="radio" value="F" <?php if ($csex == "F") {
    echo "checked";
} ?>>女
        </td>
      </tr>
      <tr>
        <td>生日</td>
        <td>
          <input type="date" name="cBirthday" id="cBirthday"
            value="<?php echo $cbirthday; ?>">
        </td>
      </tr>
      <tr>
        <td>電子郵件</td>
        <td>
          <input type="email" name="cEmail" id="cEmail"
            value="<?php echo $cemail; ?>">
        </td>
      </tr>
      <tr>
        <td>電話</td>
        <td>
          <input type="number" name="cPhone" id="cPhone"
            value="<?php echo $cphone; ?>">
        </td>
      </tr>
      <tr>
        <td>住址</td>
        <td>
          <input type="text" name="cAddr" id="cAddr" size="40"
            value="<?php echo $caddr; ?>">
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <input name="cID" type="hidden"
            value="<?php echo $cid; ?>">
          <input name="action" type="hidden" value="update">
          <input type="submit" name="button" value="更新資料">
          <input type="reset" name="button2" value="重新填寫">
        </td>
      </tr>
    </table>
  </form>
</body>

</html>
<?php
$stmt -> close();
$db_link -> close();
