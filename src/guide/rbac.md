# RBAC (Role-Based Access Control) Configuration

## Introduction

RBAC (Role-Based Access Control) is a method of managing access to resources in a system based on the roles assigned to
users. In the context of Yii 2, RBAC is implemented using the AccessControl class to define access rules for different
user roles to specific actions in a controller.
Now we introduce the access to the 5 controllers we have:

## Access Control for ReportPageController

### Action: index

Roles: ['ReportPage/index']

### Action: view

Roles: ['ReportPage/view']

### Action: create

Roles: ['ReportPage/create']

### Action: update

Roles: ['ReportPage/update']

### Action: delete

Roles: ['ReportPage/delete']

### Action: update-widget

Roles: ['ReportPage/update-widget']

### Action: add

Roles: ['ReportPage/add']

### Action: get-widget-column

Roles: ['ReportPage/get-widget-column']

### Action: run-all-widgets

Roles: ['ReportPage/run-all-widgets']

## Access Control for ReportPageWidgetController

### Action: delete

Roles: ['ReportWidget/delete']

## Access Control for ReportWidgetController

### Action: index

Roles: ['ReportWidget/index']

### Action: view

Roles: ['ReportWidget/view']

### Action: create

Roles: ['ReportWidget/create']

### Action: update

Roles: ['ReportWidget/update']

### Action: delete

Roles: ['ReportWidget/delete']

### Action: open-modal

Roles: ['ReportWidget/open-modal']

### Action: run

Roles: ['ReportWidget/run']

### Action: modal-show-chart

Roles: ['ReportWidget/modal-show-chart']

## Access Control for ReportYearController

### Action: index

Roles: ['ReportYear/index']

### Action: view

Roles: ['ReportYear/view']

### Action: create

Roles: ['ReportYear/create']

### Action: update

Roles: ['ReportYear/update']

### Action: delete

Roles: ['ReportYear/delete']

## Access Control for SharingPageController

## Action: index

Roles: ['SharingPage/index']

### Action: view

Roles: ['SharingPage/view']

### Action: create

Roles: ['SharingPage/create']

### Action: update

Roles: ['SharingPage/update']

### Action: delete

Roles: ['SharingPage/delete']

### Action: managment

Roles: ['SharingPage/managment']

### Action: expire

Roles: ['SharingPage/expire']

This project document provides an overview of the Role-Based Access Control (RBAC) configuration for the controllers and
their respective actions. The defined access rules ensure that only authorized users with specific roles can access and
perform actions within the system. If you have any further questions or need assistance, please feel free to reach out
to the project team.

