<?php

$cmd_ffmpeg = "$config[ffmpeg] -i '$video_src' -acodec libmp3lame -ar 22050 -ab 32 -f flv $video_flv";

# For old version of mplayer
# $cmd_mencoder = "$config[mencoder] '$video_src' -o $video_flv -of lavf -oac mp3lame -lameopts abr:br=56 -ovc lavc -lavcopts vcodec=flv:vbitrate=500:mbd=2:mv0:trell:v4mv:cbp:last_pred=3 -srate 22050 -lavfopts i_certify_that_my_video_stream_does_not_use_b_frames";

# For latest version of mplayer
$cmd_mencoder = "$config[mencoder] '$video_src' -o $video_flv -of lavf -oac mp3lame -lameopts abr:br=56 -ovc lavc -lavcopts vcodec=flv:vbitrate=500:mbd=2:mv0:trell:v4mv:cbp:last_pred=3 -srate 22050 -ofps 24 -vf harddup";

# Convert video to mp4
$cmd_mp4 = "$config[ffmpeg] -i '$video_src' -acodec libfaac -ab 96k -vcodec libx264 -vpre hq -crf 22 -threads 0 -b 500k $video_flv";
#$cmd_mp4 = "$config[ffmpeg] -i '$video_src' -crf 22.0 -c:v libx264 -c:a libfaac -ar 48000 -b:a 160k -coder 1 -threads 0 $video_flv";
$cmd_mp4 = "$config[ffmpeg] -i '$video_src' -crf 22.0 -c:v libx264 -c:a libfdk_aac -ar 48000 -b:a 160k -coder 1 -threads 0 $video_flv";

$convert_mp4 = $cmd_mencoder;
$convert_3gp = $cmd_mencoder;
$convert_mov = $cmd_mencoder;
$convert_asf = $cmd_mencoder;
$convert_mpg = $cmd_mencoder;
$convert_avi = $cmd_mencoder;
$convert_mpeg = $cmd_mencoder;
$convert_wmv = $cmd_mencoder;
$convert_rm = $cmd_mencoder;
$convert_dat = $cmd_mencoder;
$convert_m4v = $cmd_ffmpeg;
