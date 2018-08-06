## A Propos

ShortLink est un projet en Laravel qui permet de créer des liens courts

## QQ Considérations de mise en place

- Une tâche en cron est implémentée à une fréquence de 5 min pour maintenir le quota des liens et de supprimer ceux qui ont expirés
- Le système exige que les URLs d'origines soient actives (en ligne)
- La redirection nécessite une connexion au service ipapi pour l'IP-Géolocalisation ce qui peut provoquer une certaine latence. Ce système fonctionnera mieux si on le basculer sur les jobs en queues ce qui nécessite un processus en background avec un gestionnaire de file d'attente...

