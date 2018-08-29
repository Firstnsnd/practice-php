<html>
{!like.js!}
{data},{$person}
<ul>
{loop $b}<li>{V}</li>{/loop}
</ul>
<?php echo $pai*2;?>
{if $data=='abc'}
我是 abc
{else if $data=='def'}
我是 def
{else}
我就是我,{$data}
{/if}
{#注释不会出现在密码中#}
123456--------
</html>