# Makefile openntpd for baf modules

CUR_DIR		:= $(shell pwd)
BAF_DIR		:= /usr/local/share/baf

TOOLCHAIN	:= $(BAF_DIR)/toolchain/bin
TOOLPREFX	:= arm-linux-uclibc

TOOL_INC	:= $(BAF_DIR)/toolchain/usr/include
TOOL_LIB	:= $(BAF_DIR)/toolchain/lib
TOOL_USR_LIB	:= $(BAF_DIR)/toolchain/usr/lib

BFX_INC		:= $(BAF_DIR)/include
BFX_LIB		:= $(BAF_DIR)/lib

CFLAGS		:= "-I$(TOOL_INC) -I$(BFX_INC) -Os"
LDFLAGS		:= "-L$(TOOL_LIB) -L$(TOOL_USR_LIB) -L$(BFX_LIB)"

DEST_ROOT	:= /apps/NTP-Server
INST_PATH	:= $(CUR_DIR)

CONF_OPTS	:= --build=$(shell uname -m) --host=arm-linux --prefix=$(DEST_ROOT)
MAKE_OPTS	:= -s
INST_OPTS	:= exec_prefix=$(INST_PATH) -s

INST_DIRS	:= bin
REMV_DIRS	:= bin

TOOL_STRIP	:= $(TOOLCHAIN)/$(TOOLPREFX)-strip --remove-section={.comment,.note,.pdr}


PKG		:= OPENNTP
PKG_NAME	:= openntpd
PKG_VERSION	:= 3.9p1
PKG_SOURCE	:= $(PKG_NAME)-$(PKG_VERSION).tar.gz
PKG_SOURCE_URL	:= ftp://ftp.openbsd.org/pub/OpenBSD/OpenNTPD
PKG_DIR		:= $(CUR_DIR)/src/$(PKG_NAME)-$(PKG_VERSION)

OPENNTPD_CONFIGURE_OPTIONS += --with-privsep-user=root
OPENNTPD_CONFIGURE_OPTIONS += --with-builtin-arc4random


all: openntp openntp-install

# get the tarball
$(CUR_DIR)/src/$(PKG_SOURCE):
	@echo "   * download $(PKG_SOURCE)"
	@wget -q -P $(CUR_DIR)/src/ $(PKG_SOURCE_URL)/$(PKG_SOURCE)
	
# unpack the tarball
$(PKG_DIR)/.unpacked: $(CUR_DIR)/src/$(PKG_SOURCE)
	@echo "   * unpack $(PKG_SOURCE)"
	@zcat $(CUR_DIR)/src/$(PKG_SOURCE) | tar -C $(CUR_DIR)/src -xf -
	@touch $@

# patch the source
$(PKG_DIR)/.patched: $(PKG_DIR)/.unpacked
	@echo "   * patch $(PKG_NAME)"
	@cd $(PKG_DIR); \
	for patch_file in `/bin/ls $(CUR_DIR)/patches/*.patch`; do \
		patch -p0 < $$patch_file; \
	done
	@touch $@

# configure package
$(PKG_DIR)/.configured: $(PKG_DIR)/.patched
	@echo "   * configure $(PKG_NAME)"	
	@export PATH="$(TOOLCHAIN):$$PATH"; \
	export CC="$(TOOLPREFX)-gcc"; \
	export CPP="$(TOOLPREFX)-cpp"; \
	export CXX="$(TOOLPREFX)-g++"; \
	export CXXCPP="$(TOOLPREFX)-g++ -E"; \
	export AR="$(TOOLPREFX)-ar"; \
	export LD="$(TOOLPREFX)-ld"; \
	export NM="$(TOOLPREFX)-nm"; \
	export RANLIB="$(TOOLPREFX)-ranlib"; \
	export STRIP="$(TOOLPREFX)-strip"; \
	export CFLAGS=$(CFLAGS); \
	export LDFLAGS=$(LDFLAGS); \
	cd $(PKG_DIR); \
	if [ -x configure ]; then \
		./configure $(CONF_OPTS) $(OPENNTP_CONFIGURE_OPTIONS); \
	fi;
	@touch $@
	
# build package
$(PKG_DIR)/.compiled: $(PKG_DIR)/.configured
	@echo "   * build $(PKG_NAME)"
	@export PATH="$(TOOLCHAIN):$$PATH"; \
	cd $(PKG_DIR); \
	make $(MAKE_OPTS);
	@touch $@

# MAIN
openntp: $(PKG_DIR)/.compiled

# install
$(PKG_DIR)/.installed: $(PKG_DIR)/.compiled
	@echo "   * install $(PKG_NAME)"
	@for dir in $(INST_DIRS); do \
		mkdir -p $(CUR_DIR)/$$dir; \
	done
	cp -a $(PKG_DIR)/ntpd $(CUR_DIR)/bin/ntpd
	$(TOOL_STRIP) $(CUR_DIR)/bin/ntpd
	@touch $@

openntp-install: openntp $(PKG_DIR)/.installed

install: openntp-install

# CLEAN
clean:
	@for dir in $(REMV_DIRS); do \
		rm -rf $(CUR_DIR)/$$dir; \
	done;
	@rm -f $(PKG_DIR)/.compiled
	@rm -f $(PKG_DIR)/.configured
	@rm -f $(PKG_DIR)/.installed
	@cd $(PKG_DIR); \
	make distclean;
