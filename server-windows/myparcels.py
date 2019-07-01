import time
import datetime
import telepot
from selenium import webdriver
import pymysql
import re
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import NoSuchElementException
from selenium.webdriver.common.action_chains import ActionChains
from email.mime.text import MIMEText
import smtplib


con = pymysql.connect(host='35.206.126.144', user='remote', passwd='s59sWHwsDcaHwmVL', db='alexapar45711',charset='utf8')
stringadef =''
TOKEN = "887034241:AAE80pnhDNi5JqyXfiRcYqcDL6j7fT2HP2Q"

bot = telepot.Bot(TOKEN)
conta_bot=0
try:
    bot.sendMessage(194391563, "Server avviato, script partito")
    
except:
    print("problema")
while True:

    try:
        with con: 

            cur = con.cursor()
            cur.execute("SELECT * FROM spedizioni WHERE completo!=%s","si")

            rows = cur.fetchall()
            
            for row in rows:
                print("{0} {1} {2}".format(row[0], row[1], row[2]))  
            numrows = len(rows)
            print(numrows)
            i=0
            
            while i<numrows:
                stringa=''
                strdata=''
                driver = webdriver.Chrome()
                email=rows[i][3]
                trackme=rows[i][2]
                print(trackme)
                driver.get('https://t.17track.net/it#nums='+trackme)
                i=i+1
                time.sleep(5)

                try:
                    button=driver.find_element_by_xpath("/html[1]/body[1]/main[1]/div[1]/article[1]/div[2]/div[1]/div[1]/div[1]/div[2]/div[2]/div[2]/div[2]/div[1]/div[1]/input[1]")
                    driver.execute_script("arguments[0].click();", button)
                    time.sleep(5)
                    nn=driver.find_element_by_xpath("/html[1]/body[1]/main[1]/div[1]/article[1]/div[2]/div[1]/div[1]/div[1]/div[2]/div[1]/div[1]/div[1]/p[2]")
                    element=driver.find_element_by_xpath("/html[1]/body[1]/main[1]/div[1]/article[1]/div[2]/div[1]/div[1]/div[1]/div[2]/div[1]/div[3]/p[1]/span[1]")
                    print(element.text)
                    
                    ultima=element.text
                    statoel= driver.find_element_by_xpath("/html[1]/body[1]/main[1]/div[1]/article[1]/div[2]/div[1]/div[1]/div[1]/div[2]/div[1]/div[1]/div[1]/p[2]")
                    stato=statoel.text
                    correlem=driver.find_element_by_xpath("/html[1]/body[1]/main[1]/div[1]/article[1]/div[2]/div[1]/div[1]/div[1]/div[2]/div[1]/div[2]/div[1]/div[2]/div[1]/i[1]")
                    corriere=correlem.text

                    table_id = driver.find_element_by_xpath("/html[1]/body[1]/main[1]/div[1]/article[1]/div[2]/div[1]/div[1]/div[1]/div[2]/div[2]/div[1]/dl[2]")
                    righe = table_id.find_elements_by_tag_name("dd")
                    
                    for riga in righe:
                        
                            
                        col = riga.find_elements_by_tag_name("p")[0]
                        data = riga.find_elements_by_tag_name("time")[0]
                        datat=data.text
                        strdata=strdata+datat+'/'
                        testo=col.text
                        print(testo)
                        stringa=stringa+testo+'-'

                        
                    
                    stringa=re.sub('[!@#$%^&*()?":{}【】|<>]','', stringa)
                    ultima=re.sub('[!@#$%^&*()?":{}【】|<>]','', ultima)
                    stato=re.sub('[!@#$%^&*()?":{}【】|<>]','', stato)
                    consegn='no'
                    try:
                        
                        table_id1 = driver.find_element_by_xpath("/html[1]/body[1]/main[1]/div[1]/article[1]/div[2]/div[1]/div[1]/div[1]/div[2]/div[2]/div[1]/dl[1]")
                        righe1 = table_id1.find_elements_by_tag_name("dd")
                        strdata1= ''
                        stringa1 = ''
                        for riga1 in righe1:
                        
                            
                            col1 = riga1.find_elements_by_tag_name("p")[0]
                            data1 = riga1.find_elements_by_tag_name("time")[0]
                            datat1=data1.text
                            strdata1=strdata1+datat1+'/'
                            testo1=col1.text
                            print(testo1)
                            stringa1=stringa1+testo1+'-'
                        stringa1=re.sub('[!@#$%^&*()?":{}【】|<>]','', stringa1)
                    except:
                        strdata1=''
                        striga1=''
                    if stringa1!='':
                        stringadef=stringa1+stringa
                        datadef=strdata1+strdata1
                    else:
                        stringadef=stringa
                        datadef=strdata
                    
                    curss = con.cursor()
                    val = (trackme,email)
                    curss.execute("SELECT * FROM spedizioni WHERE track=%s AND email=%s",val)
                    rowss = curss.fetchone()
                    curssv = con.cursor()
                    curssv.execute("SELECT * FROM utenti WHERE email=%s",rowss[3])
                    rowssv = curssv.fetchone()
                    print(rowssv[10])
                    if rowssv[13]=="on":
                        if rowss[5] != ultima:
                            bot.sendMessage(rowssv[12], u'\U0001F514'+" Novità spedizione: "+rowss[1] + "\n Chiedi al tuo assistente vocale tutti i dettagli"  )
                    if rowssv[10]=="on":
                        if rowss[5] != ultima:
                            fromaddr = "alexaparcels@gmail.com" 
                            toaddr = rowss[3] 
                            html = open("emailnnn.html") 
                            msg = MIMEText(html.read(), 'html') 
                            msg['From'] = fromaddr 
                            msg['To'] = toaddr 
                            msg['Subject'] = "AlexaParcels | Novità spedizione" 
                            debug = False 
                            if debug: 
                                    print(msg.as_string()) 
                            else: 
                                    server = smtplib.SMTP('smtp.gmail.com',587) 
                                    server.starttls() 
                                    server.login("alexaparcels@gmail.com", "s59sWHwsDcaHwmVL") 
                                    text = msg.as_string() 
                                    server.sendmail(fromaddr, toaddr, text) 
                                    server.quit()
                                    print ("email inviata")
                    if rowss[9]!="si":
                        
                        if "Consegnata" in ultima :
                            consegn='forse'
                        if "consegnata" in ultima :
                            consegn='forse'
                        if "CONSEGNATA" in ultima :
                            consegn='forse'
                        if "Consegnato" in ultima :
                            consegn='forse'
                        if "consegnato" in ultima :
                            consegn='forse'
                        if "CONSEGNATO" in ultima :
                            consegn='forse'    

                    mycursor = con.cursor()
                    now = datetime.datetime.now()
                    sql = "UPDATE spedizioni SET stato=%s, ultima=%s,data=%s, totale=%s,corriere=%s, completo=%s, oraultima=%s WHERE track=%s AND email=%s"
                    oraultima=now.strftime("%Y-%m-%d %H:%M")
                    val = (stato,ultima,datadef,stringadef,corriere,consegn,oraultima,trackme,rowss[3])
                    mycursor.execute(sql, val)

                    con.commit()
                    conta_bot=conta_bot+1
                    if conta_bot >900:
                        conta_bot=0
                        bot.sendMessage(194391563, "Tutto ok, fatti "+conta_bot+"cicli")
                                               
                    

                    
                except NoSuchElementException:
                    mycursor = con.cursor()
                    print("No element found")
                    sql = "UPDATE spedizioni SET stato=%s WHERE track=%s"
                    val = ("errato",trackme)
                    mycursor.execute(sql, val)

                    con.commit()
                    conta_bot=conta_bot+1
                    
                
                    
                 
                

                
                
                driver.close()
                driver.quit()

        time.sleep(3)  

    except:
        print("fail")
        now = datetime.datetime.now()
        orafile=now.strftime("%Y-%m-%d")
        f = open ("log/"+ orafile+".txt", "a+")
        f.write("\n"+orafile+ " " + stringadef)
        f.close()
        try:
            bot.sendMessage(194391563, "Problema server: " +orafile+ " " + stringadef)
            driver.close()
            driver.quit()
            time.sleep(4)
        except:
            print("fail invio telegram")
              

