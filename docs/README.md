# Documentation
- [Testing](./Testing.md)

## Installation
### Prerequesites
- [Nextcloud](https://nextcloud.com/) *duh?*
- a working [IPFS Node](https://ipfs.io/#install)

Then clone this repo to the `apps` folder of your Nextcloud instance. And enable it in your nextcloud.

## Usage
![Screenshot 1](./img/Screen01.png)
![Screenshot 2](./img/Screen02.png)
If the IPFS node is running locally the `IPFS API` should be `http://127.0.0.1:5001/api/v0`. `Subfolder` is the root path on the node, where all document will be stored. If left empty it will just use the root storage of the IPFS node.