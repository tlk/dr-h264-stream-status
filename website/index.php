<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="da">
  <head>
    <title>DR H264 Stream Status</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="Author" content="Thomas L. Kjeldsen" />
    <style type="text/css">body { width: 1024px; }</style>
  </head>
<body>

  <h1>DR H264 Stream Status</h1>

  <p style="color:red">De gode folk hos DR svarer ikke længere på henvendelser
  vedrørende disse streams. <br>In other news: <a
  href="http://www.version2.dk/artikel/udbud-paa-vej-dr-outsourcer-drift-af-drdk-og-drnu-49007">dr.dk outsources</a></p>

  <p>Nedenstående grafer viser, på en logaritmisk skala, båndbreddeforbruget
  for et stream i bits per sekund.<br/> Hvert kvarter måles alle streams, et
  efter et, over en periode på 10 sekunder, ved hjælp af <a
  href="http://www.live555.com/openRTSP/">openRTSP</a>.<br/>
  Se mere om <a href="http://www.dr.dk/hjaelp/drdktv/20100317152244.htm">DR's H264 streams</a> på deres egen hjemmeside.</p>

  <!--
  <p>
  <h4>Nyheder 2010-11-08</h4>
  <ul>
    <li>Alt ok</li>
  </ul>
  <a href="news">se tidligere nyheder</a>
  </p>
  -->


  <p>
  Lavkvalitetssignalerne ligger normalt omkring 60kbps for audio og 240kbps for video, dvs sammenlagt ca 300kbps.<br/>
  Mediumkvalitetssignalerne ligger normalt omkring 90kbps for audio og 460kbps for video, dvs sammenlagt ca 550kbps.<br/>
  De gamle signaler fra streamer-01.dr.nordija.dk lå til sammenligning på hhv
  300kbps for lavkvalitetssignalet og 1000kbps for højkvalitetssignalet.
  </p>

  <table border="1">
    <tr><th>&nbsp;</th><th>lav</th><th>medium</th><th>høj</th></tr>
    <tr><th>rtsplive.dr.dk</th><td>300kbps</td><td>550kbps</td><td><a href="http://replay.waybackmachine.org/20090220182954/http://dr.dk/hjaelp/drdktv/20080108145038.htm">på vej (faq pkt 5)</a></td></tr>
    <tr><th>streamer-01.dr.nordija.dk</th><td>300kbps</td><td>-</td><td>1000kbps</td></tr>

  </table>

  <p>
  Graferne til venstre viser lavkvalitetssignaler mens graferne til højre viser mediumkvalitetssignaler.<br/>
  Ved normal drift er der i hver graf to linjer, grøn øverst (video) og blå nederst (audio).
  </p>

<?

function printGraphMarkup($timespan) {
  for ($channel=1; $channel<=5; $channel++) {
    for ($quality=1; $quality<=2; $quality++) {
      printf('<a href="probe?%s"><img alt="" border="0" src="livestream%d%d-%s.png"/></a>',
        "livestream".$channel.$quality,
        $channel,
        $quality,
        $timespan);
    }
  }
}

?>

  <h2>Seneste 4 timer</h2>
  <p><? printGraphMarkup('4h-now'); ?></p>

  <h2>Seneste døgn</h2>
  <p><? printGraphMarkup('1d-now'); ?></p>

  <h2>Seneste 2 uger</h2>
  <p><? printGraphMarkup('2w-now'); ?></p>


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
