# Freelance Exchange bundle

Freelance Exchange bundle for CMF Cotonti. With this bundle, you can organize any exchange to search for performers for various jobs. Its  functionality provides flexible options for operation and further development.

Authors: [Bulat Yusupov](https://github.com/devkont) и CMSWorks team, Cotonti team  
Bundle page: https://www.cotonti.com/en/extensions/commerce/freelance-bundle

## Main features

User accounts with their personal pages (contact information is displayed on the personal page, as well as lists of published projects, works in the portfolio and in the marketplace); Catalog of jobs (job projects), the ability to publish jobs. Jobs search with filtering by region and keywords; Catalog of freelancers and employers sorted by specialization; Payment module with internal user accounts and the ability to replenish and pay for services; Included payment systems: [Interkassa](https://interkassa.com/), [Robokassa](https://robokassa.com/) and WebMoney (separate plugins) and the ability to easily connect other payment systems; Paid service "PRO account"; Paid service "Paid place on the main page" (Users who have paid for this service are displayed on the main page of the exchange); Secure payment service; Reviews and ratings.

Extensions from this bundle can be installed on existing sites and used individually and only those ones that you need.

Or you can prepare a "build" that will use the built-in Cotonti installer to selectively install extensions from this bundle with the standard Cotonti extensions. This particular option is described below.

## Preparing for install

This is not a ready to use website build. To install it, you need the current version of CMF Cotonti, which can be downloaded in the [Download section](https://www.cotonti.com/download).

- Download Cotonti. Unpack the archive into the directory of the future site.
- Download Freelance Exchange bundle and unpack it into the same directory in which Cotonti is unpacked.
- Set the write permissions for folders and subfolders in the **/data** directory: **/datas/avatars**, **/data/cache** (and all subfolders), **/datas/extflds**, **/datas/photos**, **/datas/thumbs**, **/datas/users**

## Install

- Open your browser and follow the link: **http://your-domain.tld/install.php** (replace **your-domain.tld** with your domain)
- Follow the on-screen instructions until the installation is complete. During installation, select the flance installation script and bootlance theme.
- During installation, you will be prompted to select modules and plugins. The most basic extensions that are necessary for the operation of the exchange are ticked, but you can also select the rest if necessary.
- In the file datas/config.php set the option `$cfg['customfuncs'] = true`;
- Be sure to configure the Usergroupselector plugin if your site will divide users into different groups, for example, employers and freelancers. In the settings of this plugin, you need to specify which groups will be available for users to choose when registering or in the profile. If you need to create another user group, then go to the "Users" section of the admin panel.
- In order to be able to attach files and images to projects (as well as to suggestions in the description and in the portfolio), you must also install the Mavatars and Mavatarslance plugins, which also come as part of the bundle.
- Initially, your site will be empty. You can create your own categories yourself in the "Structure" section of the admin panel.

Learn more about the possibilities of the Freelance Exchange bundle: https://www.cotonti.com/en/extensions/commerce/freelance-bundle
