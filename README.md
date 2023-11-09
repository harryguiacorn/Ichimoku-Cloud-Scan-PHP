# Ichimoku Cloud Scan
- A website which scans for trading signals across major indices such as S&P 500 and their constituents based on Ichimoku Cloud indicator using PHP, HTML, CSS, Javascript and Yahoo Finance.
- cp.php is for grabbing latest data from Yahoo Finance, note that the section for updating S&P 500 stocks, it's broken into 5 links as Yahoo Finance may potentially block client's IP when the quota is hit in one go.
- When the data has been updated, head over to index.php which is the portal page where you can see scanned results.
- The indices included are S&P 500, Dow Jones 30, Nasdaq 100, FTSE 100, STOXX 50, major indices and currencies.
- The scan page shows a table with all the instruments for the specific index with Ichimoku cloud signals and Kijun-sen arrow counts.
- A stock is considered as a potential candidate to be bought when the price goes above the Ichimoku Cloud and vice versa.
- However, the Kijun-sen is often overlooked in most Ichimoku books as the first reliable hint for a stock to change from downwards sentiment to upwards and vice versa, hence, the direction to which Kijun-sen points is programmed into the scan.
- Furthermore, positive Kijun-sen arrow counts denote the number of periods which the direction of the arrow has held, it provides an elegant way to gauge strength and longevity of  the direction of a stock, simply put, stocks that have the most positive counts have turned into a upwards trend the longest among their peers.
- When the Kijun-sen arrow points down, it signals a change of direction and the count would be changed to -1.
- Oftentimes when a stock may still be below a cloud but Kijun-sen starts to point up, it may be considered bottom fishing technique but the failure rate would be higher.
- On the other hand, when a stock is already above the Ichimoku cloud and Kijun-sen changes from pointing down to up, it’s deemed as a safer option but the potential reward would be smaller.

## Portal page
![localhost_cloudservice_](https://user-images.githubusercontent.com/1398153/195997960-139c573a-74b9-494d-aa81-bcba6de8d475.jpeg)

## Ichimoku cloud signals of the index's constituents
![localhost_cloudservice_viewdowjones php](https://user-images.githubusercontent.com/1398153/195997962-8a7f46ce-b34c-4041-aa87-6d7b3858301a.jpeg)

## Control panel to update data cp.php
![localhost_cloudservice_cp php](https://user-images.githubusercontent.com/1398153/195998281-a329abac-cdbd-454d-a5c7-6ca12c6062fa.jpeg)


