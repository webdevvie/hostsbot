# Hostsbot

This is a little utility to manage my hosts file on my macbook.

## How to install from source

 - Have php 8.2+ installed
 - update the php.ini to allow phars to be [writable](https://www.php.net/manual/en/phar.configuration.php#ini.phar.readonly)
 - have composer installed
 - install [pakket](https://github.com/webdevvie/pakket)
 - run `./package.sh` to package
 - run `./install-macos.sh` you will need fill in your username
   - this creates a folder in /Applications and puts symlinks and a script to sync stuff in `/usr/local/bin/`


## BEFORE YOU CONTINUE OR RUN ANYTHING ELSE
Back . up . your . `/etc/hosts` . file

Seriously.. Do it! 


## How to use
the `install-macos.sh` script creates a directory in your homedir called `~/hostsbot`

If you place files with a name that end in `.hosts` it will be included in the `/etc/hosts` file


To try it out:
```shell
hostsbot sync -v
```
This shows you what it would write to `/etc/hosts`

To actually sync you need to have admin privileges.

```shell
sudo hostsbot sync -v --live 
```
This shows a diff of the changes too!

You can also run this command
```shell
synchostsfile
```

This is just a wrapper that runs `sudo hostsbot sync -v --live`


## Next steps
I want to implement a couple of extra features to this utility.

- Add the command to enable/disable specific files
- Add a "reset" command
- Add a "mode" where it will only include specific files
- Validate the format of the hosts file before it is saved 


## What else?
Potato! 🥔 
`I just think they are neat!` - Marge Simpson