<?php echo @$init ?>
<script type="text/javascript">
    KE.show({
        id: '<?php echo $id ?>',
        <?php foreach($attrs as $k=>$v): ?>
        <?php echo $k ?>: <?php echo (is_integer($v) OR strstr($v, '[')) ? $v : '"'.$v.'"' ?>,
        <?php endforeach; ?>
        <?php if(@$imageUploadJson){ echo 'imageUploadJson : "'.$imageUploadJson.'",'; } ?>
        <?php if(@$fileManagerJson){ echo 'fileManagerJson : "'.$fileManagerJson.'",'; } ?>
        skinsPath: '<?php echo $skinsPath ?>',
        pluginsPath: '<?php echo $pluginsPath ?>'
    });
</script>