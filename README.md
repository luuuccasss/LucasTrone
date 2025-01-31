# LucasTrone Plugin

The **LucasTrone** is plugin allows you to define a specific area in the world, called the "Throne," where players can earn money by staying in this zone.
---

## Features

- **Define a Throne Zone**: Players can define a rectangular zone using two points (point1 and point2) by breaking blocks.
- **Remove the Throne Zone**: The zone can be removed via a command.
- **Earn Money**: Players in the Throne zone earn money at regular intervals.
- **Entry and Exit Messages**: Players receive messages when they enter or leave the Throne zone.
- **Message Cooldown**: Entry and exit messages have a cooldown to prevent spam.
- **Customizable Configuration**: The amount of money earned, time interval, and messages can be configured via the `config.yml` file.

---

## Installation

1. Download the `.phar` file from the [Releases](https://github.com/luuuccasss/LucasTrone/releases) section.
2. Place the `.phar` file in the `plugins` folder of your PocketMine-MP server.
3. Restart the server to enable the plugin.
---

## Configuration

The `config.yml` file contains the following settings:

```yaml
zone: []

messages:
  usage: "§cUsage: /trone <set|remove>"
  point1_set: "§aPoint 1 set at {x}, {y}, {z}. Break another block to set point 2."
  point2_set: "§aPoint 2 set at {x}, {y}, {z}. The Throne zone has been defined."
  zone_removed: "§aThe Throne zone has been removed."
  already_defined: "§cThe Throne zone is already defined."
  trone_enter: "§e{player} has entered the Throne zone!"
  trone_leave: "§e{player} has left the Throne zone."
  trone_money: "§aYou earned {amount} $ for staying in the Throne!"

settings:
  money_per_interval: 10
  interval_seconds: 5
  message_cooldown: 10
```

### Explanation of Settings

- **zone**: Contains the coordinates of the points defining the Throne zone.
- **messages**: Contains customizable messages for different actions.
- **settings**:
  - `money_per_interval`: Amount of money earned per interval.
  - `interval_seconds`: Time interval in seconds between each money distribution.
  - `message_cooldown`: Cooldown in seconds for entry and exit messages.

---

## Commands

- **/trone set**: Defines the Throne zone by breaking two blocks to mark the points.
- **/trone remove**: Removes the Throne zone.

---

## Permissions

- **lucastrone.set**: Permission required to use the `/trone` command.

---

## Usage

1. **Define the Throne Zone**:
   - Run the command `/trone set`.
   - Break a block to set the first point.
   - Break another block to set the second point.

2. **Remove the Throne Zone**:
   - Run the command `/trone remove`.

3. **Earn Money**:
   - Stay in the Throne zone to earn money at regular intervals.

---

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

---

## Author

- **luuuccasss** - Lead Developer - [GitHub](https://github.com/luuuccasss)

---

