docker exec -d app service supervisor start
docker exec -d app supervisorctl reread
docker exec -d app supervisorctl update
docker exec -d app supervisorctl start "nice-worker:*"