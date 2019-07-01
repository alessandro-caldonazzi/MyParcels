from subprocess import Popen
import sys


while True:
    f=open("/bin/logbot.py", "a+")
    f.write("\n avvio")
    f.close()
    p = Popen("/usr/bin/sudo /usr/bin/python3 /bin/botreal.py", shell=True)
    p.wait()
