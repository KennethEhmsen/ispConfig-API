# ispConfig-API

Remote API client for ISPConfig3 to support logical operations.

Instantiate one object per server you wish to make adjustments to. Do not connect to server1
to modify server2 (at least for now as there is no way to specify your server id explicitly).

MUST be able to connect over SSL!
