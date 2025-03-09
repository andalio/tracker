# Visits Tracker

How it works?

1. Add the JavaScript tracking script to the website you want to monitor.
2. The script automatically sends a request to the tracker API (/api/track/visit) only if the visit has not already been recorded for the current day.
3. On the server side, the request is validated to check if the domain is allowed.
4. If the request is valid, a message is sent to the queue (RabbitMQ) for asynchronous processing.
5. A consumer processes the message and saves the visit to the database:
	- It checks again to ensure the visit has not already been registered.
	- A supervisor is set up to manage and restart consumers if needed.
6. You can view visit statistics on a simple web page. This allows filtering visits by domain and date range.
 - /visits/list?domain=domain.com&startDate=2025-03-01&endDate=2025-03-31

----

How to start it?

1. Install the application and set DATABASE_URL and MESSENGER_TRANSPORT_DSN parameters in .env

2. Run migrations: *php bin/console doctrine:migrations:migrate*

2. Manually insert your domain into allowed_domains, running migrations will add domain.com by default: *INSERT INTO allowed_domain (domain, active, created) VALUES ("domain.com", 1, NOW());*

3. Integrate the JavaScript on domain.com: <*script async src="/scripts/tracker.js"></script>*

4. Start RabbitMQ consumer: *php bin/console messenger:consume track.visit --limit=100*

5. (Optional) Use Supervisor: *supervisorctl start track.visit:track.visit_0*