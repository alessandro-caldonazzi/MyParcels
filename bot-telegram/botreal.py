
import time
import telepot
import pymysql
from telepot.loop import MessageLoop
from validate_email import validate_email
from telepot.namedtuple import InlineKeyboardMarkup, InlineKeyboardButton

conn = pymysql.connect(host='localhost', port=3306, user='locale', passwd='', db='alexapar45711')

benvenuto_mex = "Hey, benvenuto nel bot ufficiale di MyParcels.it. Grazie a questo bot è possibile \n - aggiungere nuove spedizioni \n - rimuovere delle spedizioni \n - Contrassegnare una spedizione come consegnata"
auth_mex = "Perfavore inviami la tua email usata nella registrazione a MyParcels.it"

keyboard = InlineKeyboardMarkup(inline_keyboard=[
    [InlineKeyboardButton(text=u'\U00002795'+' Aggiungi Spedizione '+u'\U00002795', callback_data='add')],
    [InlineKeyboardButton(text=u'\U00002796'+' Rimuovi Spedizone '+u'\U00002796', callback_data='rm')],
    [InlineKeyboardButton(text=u'\U0001F3E0'+' Spedizione Consegnata '+u'\U0001F3E0', callback_data='sc')],
    [InlineKeyboardButton(text=u'\U0001F4E6'+' Le Tue Spedizioni '+u'\U0001F4E6', callback_data='spedizioni')],
    [InlineKeyboardButton(text=u'\U00002699'+' Impostazioni '+u'\U00002699', callback_data='imp')],
])


def handle(msg):
    content_type, chat_type, chat_id = telepot.glance(msg)
    print(content_type, chat_type, chat_id)

    print("in handle is user: " + str(is_user(chat_id)))
    print("in handle is attesa: " + str(is_attesa(chat_id, "True")))
    if content_type == 'text' and msg['text'] == "/cancella":
        elimina(chat_id)
    if content_type == 'text' and msg['text'] == "/start":
        elimina(chat_id)
        start(msg['text'], chat_id)
    if not is_user(chat_id) and not is_attesa(chat_id, "True"):
        print("richiedo")
        richiesta_autenticazione(chat_id)
    elif is_attesa(chat_id, "aggiunta"):
        mx = msg['text']
        gg = mx.split()
        print("len: " + str(len(gg)))
        if len(gg) < 2 or len(gg) > 2:
            bot.sendMessage(chat_id,
                            "Formato invalido, scrivi il nome della spedizione e il tracking code divisi da uno spazio")
        else:
            elimina(chat_id)
            add_ship(chat_id, msg['text'])
    elif is_attesa(chat_id, "rm"):
        elimina(chat_id)
        rm_ship(chat_id, msg['text'])
    elif is_attesa(chat_id, "sc"):
        elimina(chat_id)
        sc_ship(chat_id, msg['text'])
    else:

        if content_type == 'text':

            if is_attesa(chat_id, "True"):
                '''sto aspettando una mail'''
                if validate_email(msg['text']):
                    add_user(chat_id, msg['text'])
                else:
                    bot.sendMessage(chat_id, "Perfavore inserisci una mail valida")

            mex = msg['text']
            if mex == '/menu':
                menu(chat_id)
    



def add_user(chat_id, mex):
    sql = """UPDATE utenti SET user_tm =%s WHERE email= %s"""
    arg = (str(chat_id), str(mex))
    cur = conn.cursor()
    cur.execute(sql, arg)
    conn.commit()
    elimina(chat_id)
    bot.sendMessage(chat_id, "Sei ufficialmente abilitato a poter utilizzare questo bot.")
    menu(chat_id)
   
def is_user(chat_id):
    cur = conn.cursor()
    cur.execute("SELECT * FROM utenti WHERE user_tm = " + str(chat_id))
    conn.commit()

    try:

        row = cur.fetchone()
        print("row " + str(row[12]))
        if str(row[12]) == str(chat_id):
            return True
        else:
            return False
    except:
        print("sono nel maledetto except")
        return False
    

def is_attesa(chat_id, scelta1):
    ret = False

    with open("/bin/attesa.txt", 'r') as f:

        file = f.readlines()
        i = 0
        while i < len(file):
            if str(chat_id) in file[i]:

                if str(scelta1) in file[i]:
                    ret = True
                else:
                    ret = False
            i = i + 1

        f.close()
    print("ret in is attesa " + str(ret))
    return ret
  

def cambia_attesa(chat_id, scelta):
    with open("/bin/attesa.txt", "r+") as f:
        new_f = f.readlines()
        f.seek(0)
        for line in new_f:
            if str(chat_id) not in line:
                f.write(line)
        f.truncate()

    f = open("/bin/attesa.txt", 'a+')
    f.write("\n" + str(chat_id) + " " + scelta)
    f.close()
    

def elimina(sc):
    with open("/bin/attesa.txt", "r+") as f:
        new_f = f.readlines()
        f.seek(0)
        for line in new_f:
            if str(sc) not in line:
                f.write(line)
        f.truncate()
    
def sc_ship(chat_id, mex):
    cur1 = conn.cursor()
    cur1.execute("SELECT * FROM utenti WHERE user_tm = " + str(chat_id))
    conn.commit()

    email = ""
    try:
        row = cur1.fetchone()
        email = str(row[2])
    except:
        email = "errore"
        elimina(chat_id)
    if not email == "errore":
        sql = """UPDATE spedizioni SET completo='si' WHERE email= %s and nome=%s"""
        arg = (str(email), str(mex))
        cur = conn.cursor()
        cur.execute(sql, arg)
        conn.commit()
        if cur.rowcount > 0:
            bot.sendMessage(chat_id, "La tua spedizione è stata contrassegnata come completata")
        else:
            bot.sendMessage(chat_id,
                            "Non è stato possibile eseguire l'operazione, riprova controllando che il nome della spedizione sia scritto in modo corretto")
    else:
        bot.sendMessage(chat_id, "Non sono riuscito a trovare nessuna mail collegata a questo account")
    menu(chat_id)
    
def richiesta_autenticazione(chat_id):
    

    cambia_attesa(chat_id, "True")
    bot.sendMessage(chat_id, auth_mex)
    


def start(mex, chat_id):
    

    bot.sendMessage(chat_id, benvenuto_mex, reply_markup=keyboard)
   

def on_callback_query(msg):
    query_id, chat_id, query_data = telepot.glance(msg, flavor='callback_query')

    if query_data == 'add':
        bot.answerCallbackQuery(query_id, text='Ok')
        bot.sendMessage(chat_id,
                        "Inviami il nome e il codice di tracking divisi da uno spazio. Es: telefono AX83992003F")
        cambia_attesa(chat_id, "aggiunta")
    elif query_data == 'rm':
        bot.answerCallbackQuery(query_id, text='Ok')
        bot.sendMessage(chat_id,
                        "Inviami il nome della spedizione che vuoi cancellare")
        cambia_attesa(chat_id, "rm")
    elif query_data == 'sc':
        bot.answerCallbackQuery(query_id, text='Ok')
        bot.sendMessage(chat_id,
                        "Inviami il nome della spedizione che ti è stata consegnata")
        cambia_attesa(chat_id, "sc")

    elif query_data == 'spedizioni':
        bot.answerCallbackQuery(query_id, text='Ok')
        my_ship(chat_id)
    elif query_data == 'imp':
        bot.answerCallbackQuery(query_id, text='Ok')
        impostazioni(chat_id)

    elif query_data == 'not_off':
        bot.answerCallbackQuery(query_id, text='Ok')
        notifiche(chat_id, "off")
    elif query_data == 'not_on':
        bot.answerCallbackQuery(query_id, text='Ok')
        notifiche(chat_id, "on")
    else:
        bot.answerCallbackQuery(query_id, text='Errore')
    
def notifiche(chat_id, sc):
    if sc == "on":
        cur1 = conn.cursor()
        cur1.execute("UPDATE utenti SET not_tm='on' WHERE user_tm = " + str(chat_id))
        conn.commit()
        bot.sendMessage(chat_id, "Ho attivato le notifiche su telegram")
    else:
        cur1 = conn.cursor()
        cur1.execute("UPDATE utenti SET not_tm='off' WHERE user_tm = " + str(chat_id))
        conn.commit()
        bot.sendMessage(chat_id, "Ho disattivato le notifiche")
    menu(chat_id)
    
def menu(chat_id):
    

    bot.sendMessage(chat_id, "MENU:", reply_markup=keyboard)
     
def impostazioni(chat_id):
    cur1 = conn.cursor()
    cur1.execute("SELECT * FROM utenti WHERE user_tm = " + str(chat_id))
    conn.commit()
    res = cur1.fetchone()
    if res[13] == "on":
        testo = "Disattiva Notifiche"
        query = "not_off"
    else:
        testo = "Attiva Notifiche"
        query = "not_on"

    keyboard1 = InlineKeyboardMarkup(inline_keyboard=[
        [InlineKeyboardButton(text=testo, callback_data=query)],
    ])

    bot.sendMessage(chat_id, u'\U0001F514' + " NOTIFICHE: " + u'\U0001F514', reply_markup=keyboard1)


def my_ship(chat_id):
    cur1 = conn.cursor()
    cur1.execute("SELECT * FROM utenti WHERE user_tm = " + str(chat_id))
    conn.commit()
    email = ""
    try:
        row = cur1.fetchone()
        email = str(row[2])
    except:
        email = "errore"
        elimina(chat_id)
    if not email == "errore":
        sql = """SELECT * FROM spedizioni WHERE email= %s"""
        arg = (str(email))
        cur2 = conn.cursor()
        cur2.execute(sql, arg)
        conn.commit()
        res = cur2.fetchall()
        mx = "LE TUE SPEDIZIONI: "
        for row in res:
            if row[9] == "si":

                mx = mx + "\n" + u'\U0001F3E0' + " " + row[1]
            else:
                mx = mx + "\n" + u'\U0001F69A' + " " + row[1]

        bot.sendMessage(chat_id, mx)
    else:
        bot.sendMessage(chat_id, "Non ho trovato nessuna email legata al tuo account")
    menu(chat_id)
    
def rm_ship(chat_id, mex):
    cur1 = conn.cursor()
    cur1.execute("SELECT * FROM utenti WHERE user_tm = " + str(chat_id))
    conn.commit()

    email = ""
    try:
        row = cur1.fetchone()
        email = str(row[2])
    except:
        email = "errore"
        elimina(chat_id)
    if not email == "errore":
        sql = """DELETE FROM spedizioni WHERE email= %s and nome=%s"""
        arg = (str(email), str(mex))
        cur = conn.cursor()
        cur.execute(sql, arg)
        conn.commit()
        print(str(cur.rowcount))
        if cur.rowcount > 0:

            bot.sendMessage(chat_id, "Spedizione eliminata")
        else:
            bot.sendMessage(chat_id, "Non sono riuscito ad eliminare la tua spedizione")
    else:
        bot.sendMessage(chat_id,
                        "Non è stato possibile aggiungere la spedizione, non è stata trovata alcuna mail legata al tuo profilo telegram")
    menu(chat_id)
    
def add_ship(chat_id, mex):
    sp = mex.split()
    nome = sp[0]
    track = sp[1]

    cur1 = conn.cursor()
    cur1.execute("SELECT * FROM utenti WHERE user_tm = " + str(chat_id))
    conn.commit()

    email = ""
    try:
        row = cur1.fetchone()
        email = str(row[2])
    except:
        email = "errore"
        elimina(chat_id)

    if not email == "errore":
        sql = """INSERT INTO spedizioni (nome, track, email) values (%s, %s, %s)"""
        arg = (str(nome), str(track), str(email))
        cur = conn.cursor()
        cur.execute(sql, arg)
        conn.commit()
        if cur.rowcount > 0:

            bot.sendMessage(chat_id,
                            "La tua spedizione è stata aggiunta correttamente, tra pochi minuti verrà elaborata e sarà possibile chiedere tutte le informazione grazie al tuo assistente")
        else:
            bot.sendMessage(chat_id, "Non sono riuscito ad eseguire l'operazione")
    else:
        bot.sendMessage(chat_id,
                        "Non è stato possibile aggiungere la spedizione, non è stata trovata alcuna mail legata al tuo profilo telegram")

    menu(chat_id)
    



bot = telepot.Bot('')
MessageLoop(bot, {'chat': handle, 'callback_query': on_callback_query}).run_as_thread()
print('Ascolto ...')

while 1:
    time.sleep(10)    
