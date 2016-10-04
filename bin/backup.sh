#!/bin/bash
#
# Send backup files to pCloud Service

cd /var/vmail/vmail1
for dir in */
do
  base=$(basename "$dir")
  tar -czf "${base}.tar.gz" "$dir"
  php ./pcloud/uploadfile.php --email="webmaster@macweb.com.br" --pass="mac212400" --folder="/cloud4" "${base}.tar.gz" >> /var/log/pcloud-backup.log
done
