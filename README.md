# dr-h264-stream-status

This is a simple setup that was used from 2009 to 2011 to monitor the H.264
RTSP stream setup that [Danmarks Radio](http://www.dr.dk) was testing.

The [monitor.py](monitor/monitor.py) script was run by cron every 10 minutes
and it started streaming each channel to be monitored for just a few seconds
using the openRTSP tool. Results from the streaming sessions were then stored
in a Round Robin Database and the graphs were updated.

All graphs were publicly available on a website which made it easy to spot past
issues. In addition to that, the [probe.php](website/probe.php) script allowed
visitors to do adhoc inspection of streams.

Dependencies:
  http://www.live555.com/openRTSP/
  http://www.rrdtool.org


[Screenshot from Internet
Archive](https://web.archive.org/web/20100516053117/http://www.thomaslkjeldsen.dk/fjernsynfordig/streams/)

![alt text](https://github.com/tlk/dr-h264-stream-status/raw/master/website/screenshot.png "Example graphs")

