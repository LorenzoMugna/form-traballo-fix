<?php
  $fileName = "../application-uploads/".basename($_GET["fileName"]);
  header("Content-Description: File Transfer");
  header("Content-Disposition: attachment; filename=".basename($fileName));
  header("Content-Type: ".mime_content_type($fileName));
  header("Content-Transfer-Encoding: binary");
  readfile($fileName);
