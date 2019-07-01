import time
from selenium import webdriver

driver = webdriver.Chrome(executable_path = '/usr/local/bin/chromedriver')
track=input("inserisci codice tracking")
driver.get('https://t.17track.net/it#nums='+track);
time.sleep(5)

element=driver.find_element_by_xpath("/html[1]/body[1]/main[1]/div[1]/article[1]/div[2]/div[1]/div[1]/div[1]/div[2]/div[2]/div[1]/dl[2]/dd[1]/div[1]/p[1]")
print(element.text)
ultima=element.text
statoel= driver.find_element_by_xpath("/html[1]/body[1]/main[1]/div[1]/article[1]/div[2]/div[1]/div[1]/div[1]/div[2]/div[1]/div[1]/div[1]/p[2]")
stato=statoel.text
correlem=driver.find_element_by_xpath("/html[1]/body[1]/main[1]/div[1]/article[1]/div[2]/div[1]/div[1]/div[1]/div[2]/div[1]/div[2]/div[1]/div[2]/div[1]/i[1]")
corriere=correlem.text

table_id = driver.find_element_by_xpath("/html[1]/body[1]/main[1]/div[1]/article[1]/div[2]/div[1]/div[1]/div[1]/div[2]/div[2]/div[1]/dl[2]")
rows = table_id.find_elements_by_tag_name("dd")
for row in rows:

        
    col = row.find_elements_by_tag_name("p")[0]
    print (col.text)

driver.quit()
