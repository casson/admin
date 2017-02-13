#!/usr/bin/python
# -*- coding: UTF-8 -*-

import urllib.request;
 
 
# 定义函数
def getData(url):
    #req = urllib.request.Request(url, None, header, None, False, method)  
    fp = urllib.request.urlopen(url);
    mybytes = fp.read();
    content = mybytes.decode("utf8");
    print(content);
    fp.close();
    
getData('http://zz.6rz.in');