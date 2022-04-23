About extension:

This extension is mainly focused on capturing users ( both Logged In and Guest users) activities on the Magento website. We are using free GeoIP(https://freegeoip.app/) to get the details based on the Ip.
The extension Capture’s the following  user activities on the website
1. Products viewed on the website
2. Products added to the compare list on the website
3. Products added to the wish list on the website
4. Products added to the cart on the website
5. Categories viewed on the website
6. CMS pages viewed on the website

The user location had been populated based on the IP address of the user. Since on the local machine, the IP address will be 127.0.0.1 (which may change based on your system setup) the user location details cannot be populated.

Visitor creation and management:

1. When a user visits the website for the first time a unique ID will be created called Visitor ID and also session Id will be created and stored. Based on the IP address rest of the data is populated and stored.
2. When a visitor visits the website in the same browser, based on the session Id the same Visitor ID will be assigned.
3. When a visitor visits the website via a different browser or a guest/private window based on the IP address the same Visitor ID will be assigned.
4. When a visitor visits the website via a different browser or a guest/private window and with different IP. Based on the location details (that have been populated using the IP address) the same Visitor ID will be assigned

Note:
1. This extension is compatible with Magento version >  2.3.0
2. This extension had been tested with the Magento luma theme
3. To activate the user location tracking kindly create an account in free GeoIP(https://freegeoip.app/). Get the API key and enter it store > settings > configurations > MOHITH > User Tracking > Free Geo IP API Key

Thank you for using the module. Always happy to hear from you. The Code improvement and Module Enhancement are Appreciated. For any Magento 2 projects or For Magento 2 Freelancing contact me at "mohithdeveloper@gmail.com".
