<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="da">
  <head>
    <title>DR H264 Stream Probing</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="Author" content="Thomas L. Kjeldsen" />
    <style type="text/css">body { width: 1024px; }</style>
  </head>
<body>
<?

$timelimit = 5;

for ($channel=1; $channel<=5; $channel++) {
  for ($quality=1; $quality<=2; $quality++) {
    $supported[] = "livestream".$channel.$quality;
  }
}

$stream = (in_array($_SERVER['QUERY_STRING'], $supported)) ? $_SERVER['QUERY_STRING'] : $supported[0];

print "<h1>DR H264 Stream Probing: $stream</h1>";
printf('
<table border="1">
  <tr><th>Stream</th><td>%s</td></tr>
  <tr><th>Time limit</th><td>%d seconds</td></tr>
  <tr><th>Time of measurement</th><td>%s</td></tr>
</table>',
  $stream,
  $timelimit,
  date('r')
);
printf('<p>testing... please wait %s seconds...</p>',$timelimit);
ob_flush();
flush();
print "<pre>";

$command = "openRTSP -t -Q -V -d $timelimit  -F /tmp/php-$stream rtsp://rtsplive.dr.dk:80/$stream.sdp";
echo "$command\n";
passthru("/home/tlk/live/testProgs/$command 2>&1");
echo '</pre>';


function printStreamProbeLinks($supported) {
  foreach ($supported as $stream) {
    printf('<li><a href="probe?%s">probe %s</a>, <a href="rtsp://rtsplive.dr.dk/%s.sdp">rtsp://rtsplive.dr.dk/%s.sdp</a></li>',
      $stream,
      $stream,
      $stream,
      $stream);
  }
}

?>
<p><a href="http://www.live555.com/openRTSP/#option-summary">openRTSP manual</a></p>
<p>Available streams:<ol><?printStreamProbeLinks($supported);?></ol></p>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
  var pageTracker = _gat._getTracker("UA-9171145-1");
  pageTracker._trackPageview();
} catch(err) {}</script>
</body>
</html>
