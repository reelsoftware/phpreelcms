# phpReel
phpReel is a free, MIT open-source subscription-based video streaming service that lets you create your platform for distributing video content in the form of movies or series.

## Some of the features that make phpReel great

### Dashboard
You, as the administrator of the application, can access the dashboard that lets you modify the platform as you see fit.


### Subscription plans with Stripe
At the heart of phpReel is the subscription plan, which lets users choose from different plans. You can have as many plans as you wish that are custom-tailored to your needs. The whole subscription process is powered by Stripe which takes care of all the payments.

### Cloud file storage with Amazon S3
You can store videos and images directly on the Amazon S3 storage and later stream them to your users. You also have the option to store them locally or embed videos from other platforms (Vimeo, YouTube).

### Chunk uploading
To allow the upload of larger files while at the same time not consuming all the resources of the web server we use chunk uploading, which cuts your files into small chunks and uploads them separately.

### Support for Movies and Series
You can distribute your content as a standalone video, we call it a "Movie", or as a series of episodes grouped into a season. This will give the end-user a familiar interface to interact with.

### User-friendly installer
phpReel ships with a simple to use the installer to get set up quickly. Follow the instructions available in the documentation.

### Translation
You can create as many translation files as you want thus empowering you with the ability to translate your platform to any language right from the comfort of your dashboard.

### Email configuration
Configure your SMTP email client right from the dashboard. More email clients coming soon!

### User administrator dashboard
You can update and chef the subscription status of any registered users.

### Roles
At the moment phpReel has two roles for its users. The default role is "user" which is the basic visitor of your application that can subscribe, watch content, and so on. The other available role is "administrator" which is the role that gives you access to the dashboard page.

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
