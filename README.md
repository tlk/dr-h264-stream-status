# dr-h264-stream-status

This is a simple setup that was used from 2009 to 2011 to monitor the H.264
RTSP streaming setup that [Danmarks Radio](http://www.dr.dk) was testing.

The [monitor.py](monitor/monitor.py) script was run by cron every 10 minutes
and it would start streaming each channel to be monitored for just a few seconds
using [openRTSP](http://www.live555.com/openRTSP/). Results from the streaming sessions were then stored
and graphs were updated using [RRDtool](http://www.rrdtool.org).

All graphs were publicly available on a website which made it easy to spot outages in the past. In addition to that, the [probe.php](website/probe.php) script let visitors perform ad hoc inspection of streams.

[Screenshot from Internet
Archive](https://web.archive.org/web/20100516053117/http://www.thomaslkjeldsen.dk/fjernsynfordig/streams/)

![alt text](https://github.com/tlk/dr-h264-stream-status/raw/master/website/screenshot.png "Example graphs")

