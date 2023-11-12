<?php

$list = $data['list']; ?>
<html>
  <h1>
    {{{ $title }}}
  </h1>

@if(1 == 1)
  <p>
    {{{ $content }}}
  </p>
@endif

@for($i = 0; $i < count($list); $i++)
  <h4>{{ $list[$i] }}</h4>
@endfor
</html>
