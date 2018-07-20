<?php
namespace App\Http\Controllers\Traits;

use GatewayClient\Gateway;
use App\Exceptions\InvalidRequestException;
use App\Models\User;

trait GatewayClient{
    /**
     * 绑定登录用户
     * @param $client_id
     * @param $user_id
     * @throws InvalidRequestException
     */
    public function bindUid($client_id, $user_id){

        Try{

            Gateway::bindUid($client_id, $user_id);

            $user = User::findOrFail($user_id);

            //绑定用户所在的群
            $groups = $user->userGroups;
            foreach ($groups as $group){
                $this->joinGroup([$user_id], $group->group_name);
            }

        }catch (\Exception $exception){

            throw new InvalidRequestException($exception->getMessage(), '31000', 500);

        }

    }

    /**
     * 绑定访客
     * @param $client_id
     * @param $mark
     * @throws InvalidRequestException
     */
    public function bindVistor($client_id, $mark){

        Try{

            Gateway::bindUid($client_id, $mark);

        }catch (\Exception $exception){

            throw new InvalidRequestException('绑定访客失败', '31000', 500);

        }

    }


    /**
     * 通知到群
     * @param String $groupName
     * @param array $message
     * @throws \Exception
     */
    public function sendToGroup(String $groupName, Array $message){
        Try{

            Gateway::sendToGroup($groupName, json_encode($message));

        }catch (\Exception $exception){

            throw new InvalidRequestException($exception->getMessage(), '31000', 500);

        }

    }

    /**
     * 用户添加到群
     * @param array $uidArr
     * @param String $groupName
     * @throws InvalidRequestException
     */
    public function joinGroup(Array $uidArr, String $groupName){

        Try{

            $clintArr = $uidArr;
            $clintIds = [];
            foreach ($clintArr as $userId){
                $clintIds = array_merge($clintIds, Gateway::getClientIdByUid($userId));
            }

            foreach ($clintIds as $clintId){
                Gateway::joinGroup($clintId, $groupName);
            }

        }catch (\Exception $exception){

            throw new InvalidRequestException($exception->getMessage(), '31001', 500);

        }
    }

    /**
     * 向客户端发送数据
     * @param array $uidArr
     * @param array $message
     * @throws InvalidRequestException
     */
    public function sendToUid(Array $uidArr, Array $message){

        Try{

            Gateway::sendToUid($uidArr, json_encode($message));

        }catch (\Exception $exception){

            throw new InvalidRequestException($exception->getMessage(), '31002', 500);

        }
    }

    /**
     * 从群聊移除用户
     * @param Integer $uid
     * @param String $group_name
     * @throws InvalidRequestException
     */
    public function levelGroup(Int $uid, String $group_name){

        Try{

            $clintIds = Gateway::getClientIdByUid($uid);
            foreach ($clintIds as $clintId){
                Gateway::leaveGroup($clintId, $group_name);
            }

        }catch (\Exception $exception){

            throw new InvalidRequestException($exception->getMessage(), '31003', 500);

        }

    }

    /**
     * 解散群
     * @param String $group_name
     * @throws InvalidRequestException
     */
    public function unGroup(String $group_name){

        Try{

            Gateway::ungroup($group_name);

        }catch (\Exception $exception){

            throw new InvalidRequestException($exception->getMessage(), '31004', 500);

        }
    }

    /**
     * 获取所有在线的用户
     * @return array
     */
    public function getAllUidList(){
        Try{

            return Gateway::getAllUidList();

        }catch (\Exception $exception){

            throw new InvalidRequestException($exception->getMessage(), '31005', 500);

        }


    }

    /**
     * 获取单个群所有在线的用户
     * @param $group_name
     * @return array
     */
    public function getUidListByGroup($group_name){

        Try{

            return Gateway::getUidListByGroup($group_name);

        }catch(\Exception $exception){

            throw new InvalidRequestException($exception->getMessage(), '31006', 500);

        }

    }

}