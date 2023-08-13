# RBAC (Role-Based Access Control) Configuration

## Introduction

RBAC (Role-Based Access Control) is a method of managing access to resources in a system based on the roles assigned to
users. In the context of Yii 2, RBAC is implemented using the AccessControl class to define access rules for different
user roles to specific actions in a controller.
Now we introduce the access to the 6 controllers we have:

## permissions  for ReportPageController

### Action: index
permission: ['ReportPage/index']
### Action: view
permission: ['ReportPage/view']
### Action: create
permission: ['ReportPage/create']
### Action: update
permission: ['ReportPage/update']
### Action: delete
permission: ['ReportPage/delete']
### Action: update-widget
permission: ['ReportPage/update-widget']
### Action: add
permission: ['ReportPage/add']
### Action: get-widget-column
permission: ['ReportPage/get-widget-column']
### Action: run-all-widgets
permission: ['ReportPage/run-all-widgets']


## permissions for ReportPageWidgetController
### Action: delete
permission: ['ReportWidget/delete']


## permissions for DefaultController
### Action: index
permission: ['Default/index']


## permissions for ReportWidgetController
### Action: index
permission: ['ReportWidget/index']
### Action: view
permission: ['ReportWidget/view']
### Action: create
permission: ['ReportWidget/create']
### Action: update
permission: ['ReportWidget/update']
### Action: delete
permission: ['ReportWidget/delete']
### Action: open-modal
permission: ['ReportWidget/open-modal']
### Action: run
permission: ['ReportWidget/run']
### Action: modal-show-chart
permission: ['ReportWidget/modal-show-chart']



## permissions for ReportYearController
### Action: index
permission: ['ReportYear/index']
### Action: view
permission: ['ReportYear/view']
### Action: create
permission: ['ReportYear/create']
### Action: update
permission: ['ReportYear/update']
### Action: delete
permission: ['ReportYear/delete']



## permissions for SharingPageController
## Action: index
permission: ['SharingPage/index']
### Action: view
permission: ['SharingPage/view']
### Action: create
permission: ['SharingPage/create']
### Action: update
permission: ['SharingPage/update']
### Action: delete
permission: ['SharingPage/delete']
### Action: managment
permission: ['SharingPage/managment']
### Action: expire
permission: ['SharingPage/expire']

This project document provides an overview of the Role-Based Access Control (RBAC) configuration for the controllers and
their respective actions. The defined access rules ensure that only authorized users with specific roles can access and
perform actions within the system. If you have any further questions or need assistance, please feel free to reach out
to the project team.

