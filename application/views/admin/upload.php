<!DOCTYPE html>

<html>

<head>

<title>Codeigniter Upload Example</title>

</head>

<body>

<?php echo $error; ?>

<h3>Upload Example</h3>

<?php echo form_open_multipart('upload/upload_file'); ?>

<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="upload" />

</form>

</body>

</html>
