from lxml import etree
from lxml import html
import requests
import json
import re
import time
import pandas as pd

def convertToHtml(result,title):
    #将数据转换为html的table
    #result是list[list1,list2]这样的结构
    #title是list结构；和result一一对应。titleList[0]对应resultList[0]这样的一条数据对应html表格中的一列
    d = {}
    index = 0
    for t in title:
        d[t]=result[index]
        index = index+1
    df = pd.DataFrame(d)
    df = df[title]
    h = df.to_html(index=False)
    return h



headers = {
    'User-Agent': 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.63 Safari/537.36'}
page = requests.get("https://www.baidu.com", headers=headers)
html = page.text
# print(source1)
# 从字符串解析
element = etree.HTML(html)

# 元素列表，获取的方式列出了如下两种
# ps = element.xpath('//*[@id="hotsearch-content-wrapper"]/li/a/span[2]')
ps = element.xpath('//*[@class="title-content-title"]')

# 热搜文本内容
text = []
if len(ps) > 0:
    for p in ps:
        # 输出节点的文本
        text1 = p.text
        text.append(text1)
else:
    print("空")

x = element.xpath('//*[@class="s-hotsearch-content"]/li')

# 热搜文本对应的排名
index = []
for x1 in x:
    # 获取节点的属性
    index1 = x1.get("data-index")
    index.append(index1)



# 定义一个对文本和排名进行匹配的函数，返回一个字典型数据
def PP(index_array, text_array):
    x = {}
    i = 0
    for index_a in index_array:
        # index_a = int(index_a)

        x[index_a] = text_array[i]
        i = i + 1
    return x


re_text = PP(index, text)
# 对字典性数据按key进行排序，即key=lambda re:re[0]，排序完成后再转换为字典型数据
last_text = dict(sorted(re_text.items(), key=lambda re: re[0]))

re = json.dumps(last_text,ensure_ascii=False,indent=4)
re = re.replace("{"," ")
re = re.replace("}"," ")
re = re.replace('"'," ")
re = re.replace(",","</p><p>")
print(re)

shi = time.strftime("%Y %b %d %a ", time.localtime())
#C



session = requests.session()

tian = session.get("https://api.map.baidu.com/weather/v1/?district_id=440118&data_type=all&ak=IkicOwF90RkE2fG2zcKWnRShc7t5KqIo")
tian = json.loads(tian.text)
#获取城市
tian_city = tian['result']["location"]["name"]
#获取时间
tian_now_date = tian["result"]["forecasts"][0]["date"]
tian_tomorrow_date = tian["result"]["forecasts"][1]["date"]
tian_after_tomorrow_date = tian["result"]["forecasts"][2]["date"]
tian_now_week = tian["result"]["forecasts"][0]["week"]
tian_tomorrow_week = tian["result"]["forecasts"][1]["week"]
tian_after_tomorrow_week = tian["result"]["forecasts"][2]["week"]
#获取白天天气
tian_now_text_day = tian["result"]["forecasts"][0]["text_day"]
tian_tomorrow_text_day = tian["result"]["forecasts"][1]["text_day"]
tian_after_tomorrow_text_day = tian["result"]["forecasts"][2]["text_day"]
#获取晚上天气
tian_now_text_night = tian["result"]["forecasts"][0]["text_night"]
tian_tomorrow_text_night = tian["result"]["forecasts"][1]["text_night"]
tian_after_tomorrow_text_night = tian["result"]["forecasts"][2]["text_night"]
#获取最高温度 (℃)
tian_now_high = tian["result"]["forecasts"][0]["high"]
tian_tomorrow_high = tian["result"]["forecasts"][1]["high"]
tian_after_tomorrow_high = tian["result"]["forecasts"][2]["high"]
#获取最低温度 (℃)
tian_now_low = tian["result"]["forecasts"][0]["low"]
tian_tomorrow_low = tian["result"]["forecasts"][1]["low"]
tian_after_tomorrow_low = tian["result"]["forecasts"][2]["low"]
#获取白天风力
tian_now_wc_day = tian["result"]["forecasts"][0]["wc_day"]
tian_tomorrow_wc_day = tian["result"]["forecasts"][1]["wc_day"]
tian_after_tomorrow_wc_day = tian["result"]["forecasts"][2]["wc_day"]
#获取晚上风力
tian_now_wc_night = tian["result"]["forecasts"][0]["wc_night"]
tian_tomorrow_wc_night = tian["result"]["forecasts"][1]["wc_night"]
tian_after_tomorrow_wc_night = tian["result"]["forecasts"][2]["wc_night"]
#获取白天风向
tian_now_wd_day = tian["result"]["forecasts"][0]["wd_day"]
tian_tomorrow_wd_day = tian["result"]["forecasts"][1]["wd_day"]
tian_after_tomorrow_wd_day = tian["result"]["forecasts"][2]["wd_day"]
#获取晚上风向
tian_now_wd_night = tian["result"]["forecasts"][0]["wd_night"]
tian_tomorrow_wd_night = tian["result"]["forecasts"][1]["wd_night"]
tian_after_tomorrow_wd_night = tian["result"]["forecasts"][2]["wd_night"]
#获取现在体感温度，相对湿度，温度
tian_now_feels_like = tian["result"]["now"]["feels_like"]
tian_now_rh = tian["result"]["now"]["rh"]
tian_now_temp = tian["result"]["now"]["temp"]

result = [[tian_now_date,tian_tomorrow_date,tian_after_tomorrow_date],[tian_now_week,tian_tomorrow_week,tian_after_tomorrow_week],[tian_now_text_day,tian_tomorrow_text_day,tian_after_tomorrow_text_day],[tian_now_text_night,tian_tomorrow_text_night,tian_after_tomorrow_text_night],[tian_now_high,tian_tomorrow_high,tian_after_tomorrow_high],[tian_now_low,tian_tomorrow_low,tian_after_tomorrow_low],[tian_now_wc_day,tian_tomorrow_wc_day,tian_after_tomorrow_wc_day],[tian_now_wc_night,tian_tomorrow_wc_night,tian_after_tomorrow_wc_night],[tian_now_wd_day,tian_tomorrow_wd_day,tian_after_tomorrow_wd_day],[tian_now_wd_night,tian_tomorrow_wd_night,tian_after_tomorrow_wd_night]]
title = [u'日期',u'星期',u'白天天气',u'晚上天气',u'最高温度(℃)',u'最低温度(℃)',u'白天风力',u'晚上风力',u'白天风向',u'晚上风向']
a = convertToHtml(result,title)


yi = requests.session()
yan = yi.get("https://v1.hitokoto.cn/?c=a&c=d&c=i&c=j")

yan1 = json.loads(yan.text)
yan = yan1["hitokoto"]
yan_from = yan1["from"]
yan_type = yan1["type"]
yan_lei = ' '
if str(yan_type) == 'a':
    yan_lei = '动画'
if str(yan_type) == 'd':
    yan_lei = '文学'
if str(yan_type) == 'i':
    yan_lei = '诗词'
if str(yan_type) == 'j':
    yan_lei = '网易云'
yiyan = yan + '</p><p>' + '<p style="text-align:right;">----' + yan_from + '(' + yan_lei + ')'

with open('./server file/index_night.html','r') as file_obj:
    content1 = file_obj.read()
    print(content1)
file_obj.close()
f3 = open('./server file/index_night.html','w')
content1 = int(content1) + 1
f3.write(str(content1))
f3.close()


content= str('<strong> <span style="font-size:32.0px;color:#00D5FF;"> <em><span style="color:#000000;">Hi,wang 晚上好！</span></em></span></strong>'+'</p><p>'+'<strong> <span style="font-size:24.0px;color:#00D5FF;"> <em><span style="color:#000000;">天气预报</span></em></span></strong>'+'</p><p>'+'当前体感温度:'+str(tian_now_feels_like)+'℃    '+'当前相对湿度:'+str(tian_now_rh)+'     '+'当前温度:'+str(tian_now_temp)+'℃    '+a+'</p><p></p><p>'+'<strong> <span style="font-size:24.0px;color:#00D5FF;"> <em><span style="color:#000000;">今日热点</span></em></span></strong>'+"</p><p>"+re+'</p><p>'+'<strong> <span style="font-size:24.0px;color:#00D5FF;"> <em><span style="color:#000000;">一言</span></em></span></strong>'+'</p><p>'+yiyan+'</p><p>'+'</p><p>'+'<p style="text-align:right;"><span style="font-size:9px;">by wang(本消息由redian_push自动推送！)</span></span></p>')
re1 = content.replace("\n"," ")
print(content)
f1 = open(str(content1)+'_tui_night'+'.html','w')
f1.write(content)
f1.close()


#<strong> <span style="font-size:32.0px;color:#00D5FF;"> <em><span style="color:#000000;">Hi,wang 欢迎来到推送索引面板！</span></em></span></strong></p><p><strong></p><p></p><p>

f2 = open('tui.html','r+',encoding='UTF-8')
f2.read()
time1 = time.strftime("%Y-%m-%d %H:%M:%S", time.localtime())
f2.write(time1+'-------'+'<a href="./'+str(content1)+'_tui_day'+'.html">'+str(content1)+'_tui_night'+'</a>'+'</p><p>')
f2.close()
