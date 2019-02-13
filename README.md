Professional Trekspert [Holly Amos](https://twitter.com/hollyamos22) rewatched all 726 Star Trek episodes and 13 movies in 2016. 

Her live tweets of each episode included different factoids/behind-the-scenes information that are pretty interesting and made me want to re-watch the series myself. 

She archived her tweets, but [the Google Spreadsheet](https://docs.google.com/spreadsheets/d/11hjce8KOz3WMoi_RDMtDuGe2lUUaIpnEk9fJP33UCHA/) was ugly and a little hard to read so I did this because I was bored.

It doesn't look pretty, but is easier to navigate then the spreadsheet was.

---

It's currently sitting at [https://star-trek-50-tweets.herokuapp.com/](https://star-trek-50-tweets.herokuapp.com/)

_It's probablty hibernating and may take a few seconds to wake up._

**Use cmd/ctrl + f to search.**

---

**To get it running locally:**

* After cloning repo, run:

	``` composer install ```

* Create a database.

* Rename .env.example to .env, add database credentials.

* To create a tweets table and populate it, run:

	``` ./populateDatabase populate ``` 

* Start a local php server:

	``` php -S localhost:8000 -t public```

* visit localhost:8000 in a web browser to view tweets.
