# Demo App
Import products from text file on a catalog.

### Sucess case
Add a catalog
	State transition: Initiated => Pending

Start import products asynchronously
	State transition: Pending => Pending

When processing is finished, job changes status from Processing => Success


Publish products
	State transition: Sucess => Published
	
### Failure case
