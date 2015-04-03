<head>
    <title><?= $this->title ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">

    <?php 
    // echo '<pre>'; var_dump($this->js_files); echo '</pre>';

    foreach($this->js_files as $js_file) { ?>
        <script type="text/javascript" src="<?= ((strpos($js_file, 'http://') === false) ? '/assets/js/' . $js_file : $js_file) ?>"></script>
    <?php } ?>
</head>