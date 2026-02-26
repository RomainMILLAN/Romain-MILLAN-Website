# alpine 24
FROM node:25

RUN apt-get update \
  && apt-get install -y --no-install-recommends \
    libgtk2.0-0 \
    libnotify-dev \
    libgconf-2-4 \
    libnss3 \
    libxss1 \
    libasound2 \
    xvfb \
    nasm \
  && rm -rf /var/lib/apt/lists/*

# Optional: keep npm bundled with Node unless you really need latest
# RUN npm install -g npm
# RUN npm install -g gulp

# Set PROJECT USER with dynamic uid/gid from build args
ARG APP_USER_ID=999
ARG APP_GROUP_ID=999

RUN groupadd -g ${APP_GROUP_ID} project \
  && useradd -u ${APP_USER_ID} -g ${APP_GROUP_ID} -m -s /bin/bash project

USER project
WORKDIR /project

CMD ["tail", "-f", "/dev/null"]
