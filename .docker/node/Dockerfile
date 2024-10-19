FROM node:20

RUN apt-get update && \
  apt-get install -y \
    libgtk2.0-0 \
    libnotify-dev \
    libgconf-2-4 \
    libnss3 \
    libxss1 \
    libasound2 \
    xvfb \
    nasm

# Update npm to latest version
RUN npm install -g npm

# versions of local tools
RUN node -v
RUN npm -v
RUN yarn -v

## Set user permission
ARG APP_USER_ID
ARG APP_GROUP_ID

# Check if the group exists
RUN if getent group ${APP_GROUP_ID} ; then \
      echo "Group with GID ${APP_GROUP_ID} already exists" ; \
    else \
      groupadd -g ${APP_GROUP_ID} project ; \
    fi

# Check if the user exists
RUN if id -u ${APP_USER_ID} > /dev/null 2>&1 ; then \
      echo "User with UID ${APP_USER_ID} already exists" ; \
    else \
      useradd -u ${APP_USER_ID} -g ${APP_GROUP_ID} -ms /bin/bash project ; \
    fi

USER project
WORKDIR /project

CMD tail -f /dev/null
