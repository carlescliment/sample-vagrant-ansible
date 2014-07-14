# Vagrant + Ansible LAMP example

Vagrant environment for PHP, Linux, Apache and MySQL provisioned with Ansible.

## Instructions

- `git clone` this project.
- `vagrant up`
- Add the line `192.168.33.14   dev.my-project.com` to your `/etc/hosts`
- Open the url `http://dev.my-project.com/` in your favourite browser.

Amazing, isn't it?


## Credits

Lots of thanks to [@simonvlc](https://github.com/simonvlc) for his outstanding documentation and guidance.

Thanks also to [@oskarcalvo](https://github.com/oskarcalvo) for the links he sent to me on twitter:

- https://github.com/qandidate-labs/ansible-lamp-server
- https://github.com/fourkitchens/server-playbooks/tree/master/ubuntu-12.04-lamp-dev
- http://labs.qandidate.com/blog/2013/11/21/installing-a-lamp-server-with-ansible-playbooks-and-roles/
