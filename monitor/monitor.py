#!/usr/local/bin/python

import subprocess
import os
import sys

subsession = "";
datadir = "/data/www3029/public/fjernsynfordig/streams"
datafile = datadir + "/" + "dr-rtsp-streams.rrd"
lockfile = datadir + "/" + ".monitor-lockfile"

logdata = {}

channel_label = {}
channel_label[1] = "DR1"
channel_label[2] = "DR2"
channel_label[3] = "DR Update"
channel_label[4] = "DR K"
channel_label[5] = "DR Ramasjang"

quality_label = {}
quality_label[1] = "lav"
quality_label[2] = "medium"


def format_stream_name(channel, quality):
  return "livestream%d%d" % (channel,quality)

def format_ds_name(channel, quality, media):
  return "%s%d%d" % (media, channel, quality)

def add_log_data(channel, quality, media, value):
  logdata[ format_ds_name(channel, quality, media) ] = value

def write_log_to_rrd():
  values = ""
  keys = logdata.keys()
  keys.sort()
  for key in keys:
    values += ":"+logdata[key]

  #cmd = "/usr/local/bin/rrdtool updatev"
  cmd = "/usr/local/bin/rrdtool update"
  args = " %(datafile)s N%(values)s" \
    % {"datafile":datafile, "values":values}
  #print cmd + args
  subprocess.call(cmd + args, shell=True)

def probe(channel, quality):
  stream = format_stream_name(channel, quality)
  cmd = "/home/tlk/live/testProgs/openRTSP"
  args = " -t -Q -V -d 10 -F /tmp/probe-%(stream)s rtsp://rtsplive.dr.dk:80/%(stream)s.sdp" \
    % {"stream":stream}
  #print cmd + args
  #cmd = "cat out >&2";
  #args = ""
  for line in subprocess.Popen(cmd + args, shell=True, stderr=subprocess.PIPE).stderr:
    tuples = line.split('	')
    if len(tuples) == 2:
      if tuples[0] == "subsession":
        subsession = tuples[1]

      if tuples[0] == "kbits_per_second_ave":
        media = subsession.strip().split('/')[0]
        value = tuples[1].strip()
        #print stream + ", " + media + ": " + value
        if value != "unavailable":
          add_log_data(channel, quality, media, value)

def draw(channel, quality):
  drawtimespan(channel, quality, "4h", "now")
  drawtimespan(channel, quality, "1d", "now")
  drawtimespan(channel, quality, "2w", "now")

def drawtimespan(channel, quality, begin, end):
  stream = format_stream_name(channel, quality)
  filename = "%(datadir)s/%(stream)s-%(begin)s-%(end)s.png" \
    % {"datadir":datadir, "stream":stream, "begin":begin, "end":end}
  label = "\"%(channel)s (%(quality)s)\"" \
    % {"channel":channel_label[channel], "quality":quality_label[quality]}

  cmd = "/usr/local/bin/rrdtool graph"
  args = " --logarithmic \
           --units=si \
           %(filename)s \
           -a PNG \
           --start end-%(begin)s \
           --end %(end)s \
           --title %(label)s \
           DEF:video=%(datafile)s:%(video_ds)s:AVERAGE \
           DEF:audio=%(datafile)s:%(audio_ds)s:AVERAGE \
           CDEF:cvideo=video,%(scale)s,* \
           CDEF:caudio=audio,%(scale)s,* \
           LINE2:cvideo#%(video_color)s:\"%(video_stream_desc)s\l\" \
           LINE2:caudio#%(audio_color)s:\"%(audio_stream_desc)s\l\" \
            >/dev/null" \
            % {"datafile":datafile,
               "filename":filename,
               "begin":begin,
               "end":end,
               "label":label,
               "video_ds":format_ds_name(channel, quality, "video"),
               "audio_ds":format_ds_name(channel, quality, "audio"),
               "video_stream_desc":format_stream_name(channel, quality)+" (video)",
               "audio_stream_desc":format_stream_name(channel, quality)+" (audio)",
               "video_color":"009900",
               "audio_color":"000099",
               "scale":1000,
              }

  #print cmd + args
  subprocess.call(cmd + args, shell=True)


if os.path.exists(lockfile):
  print lockfile+" found, exiting..."
  sys.exit(1)

os.open(lockfile, os.O_RDWR|os.O_CREAT)
for channel in range(1,6):
  for quality in range(1,3):
    logdata[ format_ds_name(channel, quality, 'video') ] = 'U'
    logdata[ format_ds_name(channel, quality, 'audio') ] = 'U'

for channel in range(1,6):
  for quality in range(1,3):
    probe(channel, quality)

write_log_to_rrd()

for channel in range(1,6):
  for quality in range(1,3):
    draw(channel, quality)

os.remove(lockfile);
