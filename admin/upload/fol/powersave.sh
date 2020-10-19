#!/bin/bash

find /sys/devices/pci* -path "*power/control" -exec \
  bash -c "echo -n '{}' = && cat '{}' && echo auto > '{}' && echo -n '{}' = && cat '{}'" \;

F="/sys/module/snd_hda_intel/parameters/power_save"
echo -n $F = && cat $F
echo 1 > $F
echo -n $F = && cat $F
