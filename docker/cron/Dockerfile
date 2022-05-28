FROM alpine:3 AS development

FROM development AS deployment

ENV TZ=Asia/Tokyo

COPY ./docker/cron/cron.sh /var/lib/cron.sh

RUN apk update \
  && apk --no-cache add coreutils curl jq mysql-client tzdata \
  && cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime \
  && apk del tzdata

RUN echo '0 3 * * * sh /var/lib/cron.sh' > /var/spool/cron/crontabs/root
ENTRYPOINT ["crond", "-f"]
