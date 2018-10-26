<html>

<head>

<title>Codeigniter File Upload Success</title>

</head>

<body>

<h3>File has been uploaded.</h3>

<ul>

<?php foreach ($upload_data as $item => $value): ?>

<li><?php echo $item;?>: <?php echo $value;?></li>

<?php endforeach; ?>

<li><?php echo "<h3>Uploaded file:</h3>"; ?></li>
<li>
  <img src="<?php echo base_url().'/uploads/'.$upload_data['file_name']; ?>" /></li>

</ul>

<p><?php echo anchor('upload', 'Upload Another File!'); ?></p>

</body>

</html>