# Ichimoku Cloud Scan
- A full-stack website which scans for trading signals across major indices such as S&P 500 and their constituents based on Ichimoku Cloud indicator using PHP, HTML, CSS, Javascript and Yahoo Finance.
- cp.php is for grabbing latest data from Yahoo Finance, note that the section for updating S&P 500 stocks, it's broken into 5 links as Yahoo Finance may potentially block client's IP when the quota is hit in one go.
- A stock is considered as a potential candidate to be bought when the price goes above the Ichimoku Cloud and vice versa.
- However, the Kijun-sen is often overlooked in most Ichimoku books as the first reliable hint for a stock to change from downwards sentiment to upwards and vice versa, hence, the direction to which Kijun-sen points is programmed into the scan.

## Portal page
![localhost_cloudservice_](https://user-images.githubusercontent.com/1398153/195997960-139c573a-74b9-494d-aa81-bcba6de8d475.jpeg)

## Ichimoku cloud signals of the index's constituents
![localhost_cloudservice_viewdowjones php](https://user-images.githubusercontent.com/1398153/195997962-8a7f46ce-b34c-4041-aa87-6d7b3858301a.jpeg)

## Control panel to update data cp.php
![localhost_cloudservice_cp php](https://user-images.githubusercontent.com/1398153/195998281-a329abac-cdbd-454d-a5c7-6ca12c6062fa.jpeg)
