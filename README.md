# Racing calendar

**This website is only meant to be used privately.**

A small website to organize gatherings for regular events, like auto racing events.
This Laravel application is developed with Formula One races in mind.

There is no user registration process. (Adding or modifying users can be done
through Tinker.) Users have access to everything. You can have only one season
per year.

Through a special URL with a token everyone with knowledge of this URL will be able
to assign locations to races, until after the starting time.

If you try to access the website without the token or login, you will still see
a calendar if available, but without locations, to at least protect everyone's
privacy a little.
