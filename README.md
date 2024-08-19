# AdvancedWarp

**AdvancedWarp** is a feature-rich warp management plugin for PocketMine-MP servers. It allows server administrators to set, delete, and manage warp points and enables players to teleport to these designated locations with ease.

## Features

- **Set Warp Points**: Define warp points at your current location with custom names and optional descriptions.
- **Delete Warps**: Remove existing warp points when they are no longer needed.
- **List Warps**: Display a list of all available warp points.
- **Teleport to Warps**: Instantly teleport to any warp point by name.
- **Permissions Management**: Control who can use and manage warp points with customizable permissions.

## Installation

1. **Download**: Get the latest `.phar` file from the [releases page](https://github.com/JubayerKhan-hub/AdvancedWarp/releases).
2. **Place the Plugin**: Move the `.phar` file into the `plugins` directory of your PocketMine-MP server.
3. **Restart the Server**: Restart your server to load the plugin.

## Commands

- `/warp set <name> [description]`
  - **Description**: Sets a new warp point at your current location with an optional description.
  - **Usage Example**: `/warp set spawn Main spawn point for new players`

- `/warp delete <name>`
  - **Description**: Deletes an existing warp point.
  - **Usage Example**: `/warp delete spawn`

- `/warp list`
  - **Description**: Lists all the available warp points.
  - **Usage Example**: `/warp list`

- `/warp <warp_name>`
  - **Description**: Teleports you to the specified warp point.
  - **Usage Example**: `/warp spawn`

## Permissions

- `advancedwarp.use`
  - **Description**: Allows players to use warp commands.
  - **Default**: true

- `advancedwarp.admin`
  - **Description**: Allows players to manage (set, delete) warp points.
  - **Default**: op

## Configuration

The plugin automatically manages warp data in a `warps.json` file located in the plugin data folder. The file format is JSON and includes details such as coordinates and descriptions of warp points. The file is updated automatically as changes are made.

## Example Usage

### Setting a Warp
To set a warp point named `spawn` with a description:
```bash
/warp set spawn The main spawn point
