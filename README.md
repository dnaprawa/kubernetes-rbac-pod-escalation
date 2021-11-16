# Kubernetes RBAC Pod Escalation – Application

By default, you can think about Kubernetes Pods as "quite secure". Every Pod uses a `default` service account, which has no assigned permissions to Kubernetes API (at least as of Kubernetes 1.22), so it behaves essentially like an `unauthenticated` user. However, some ignorance in RBAC can give the attacker a possibility to even kill your entire Kubernetes cluster.

This example app is used for **Kubernetes Security Workshop**. More details can be found on [wKontenerach.pl](https://wkontenerach.pl).


## Author

Damian Naprawa
wkontenerach.pl
